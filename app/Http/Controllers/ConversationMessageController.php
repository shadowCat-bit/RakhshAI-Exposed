<?php

namespace App\Http\Controllers;

use App\Events\NewResponse;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\UserAi;
use App\Models\UserToken;
use Illuminate\Http\Request;
use App\Services\ChatGPT\ApiService;
use App\Services\User\ChatService;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ConversationMessageController extends Controller {

    private $apiService;

    public function __construct() {
        $this->apiService = new ApiService();
    }

    // store conversation message
    public function conversationMessageStore(Request $request) {

        $userId = auth()->user()->id;
        $uuid = auth()->user()->uuid;
        $msg = $request->get('content');
        $convId = $request->get('id');
        $toneId = $request->get('tone_id', 1);
        $characterId = $request->get('character_id', 1);
        $aiId = $request->get('ai_id', null);
        $version = $request->get('version', 1);
        $convUUId = null;
        $error = null;
        $conv = null;

        if ($version == 1 or $version == 2) {
            $aiId = null;
        }

        if (is_null($msg)) {
            $error = json_encode(['error' => 'INVALID_PARAMETERS']);
        } elseif ($this->apiService->wordsCount($msg) > 10000) {
            $error = json_encode(['error' => 'LONG_TEXT']);
        } elseif (UserToken::whereUserId($userId)->where('remaining_tokens', '<=', 0)->exists()) {
            $error = json_encode(['error' => 'NOT_ENOUGH_TOKENS']);
        } elseif (!is_null($convId) and !$conv = Conversation::whereId($convId)->whereUserId($userId)->first()) {
            $error = json_encode(['error' => 'INVALID_CONVS_ID']);
        }

        if ($version == 2) {
            $canUserUseZalv2 = (new ChatService)->canUserUseZalv2($userId);
            if (!$canUserUseZalv2) {
                $error = json_encode(['error' => 'USER_CANNOT_USE_ZALV2']);
            }
        }

        if (!is_null($error)) {
            event(new NewResponse(['data' => $error, 'conv_id' => $convId, 'conv_uuid' => $convUUId], $uuid));
            return;
        }

        if (is_null($convId)) {
            $conv = Conversation::create([
                'uuid' => Str::uuid()->toString(),
                'user_id' => $userId,
                'title' => 'گفتگو شماره ' . Conversation::whereUserId($userId)->count() + 1,
                'tone_id' => $toneId,
                'character_id' => $characterId,
                'ai_id' => $aiId,
                'version' => $version,
            ]);
            $convId = $conv->id;
            $convUUId = $conv->uuid;
            event(new NewResponse(json_encode(['data' => ['conv' => $conv], 'conv_id' => $convId, 'conv_uuid' => $convUUId]), $uuid));
        } else {
            $convUUId = $conv->uuid;
            $toneId = $conv->tone_id;
            $characterId = $conv->character_id;
            $aiId = $conv->ai_id;
            $version = $conv->version;
        }

        if ($aiId and !UserAi::whereId($aiId)->exists()) {

            $error = json_encode(['error' => 'AIID_DELETED']);
            event(new NewResponse(['data' => $error, 'conv_id' => $convId, 'conv_uuid' => $convUUId], $uuid));

            return;
        }

        $userMsg = ConversationMessage::create([
            'conversation_id' => $convId,
            'role' => 'user',
            'content' => $msg,
            'tokens' => $this->apiService->wordsCount($msg)
        ]);

        $messages = ConversationMessage::select(['role', 'content'])
            ->whereConversationId($convId)
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get()
            ->reverse()
            ->toArray();
        $messages = array_values($messages);

        $assistantMsg = ConversationMessage::create([
            'conversation_id' => $convId,
            'role' => 'assistant',
            'content' => '',
            'tokens' => 0
        ]);

        $finalRes = '';
        try {
            $stream = $this->getStream($version, $messages, $toneId, $characterId, $aiId);
            $currentWords = '';
            $currentTokens = 0;
            foreach ($stream as $res) {
                $data = $res->choices[0]->toArray();
                if (Arr::has($data, 'delta') and !$data['finish_reason'] and !isset($data['delta']['role'])) {
                    if (isset($data['delta']['content'])) {
                        $content = $data['delta']['content'];
                    } else {
                        $data['delta']['content'] = '0';
                        $content = '0';
                    }
                    $finalRes .= $content;
                    $currentWords .= $content;
                    $currentTokens = $this->apiService->wordsCount($currentWords);
                    if ($currentTokens >= 30) {
                        try {
                            $currentWords = '';
                            $assistantMsg->content = $finalRes;
                            $assistantMsg->tokens += $currentTokens;
                            $assistantMsg->save();
                            Conversation::whereId($convId)->increment('total_tokens', $currentTokens);
                            if (ConversationMessage::whereId($assistantMsg->id)->whereIsStop(true)->exists()) {
                                break;
                            }
                            $this->decreaseUserToken($userId, $version, $currentTokens);
                        } catch (Throwable $ex) {
                            Log::error($ex->getMessage());
                            Log::info(['user_id' => $userId, 'conv_id' => $convId, 'msg_id' => $assistantMsg->id, 'content' => $msg, 'res' => $finalRes]);
                        }
                    }
                } elseif (isset($data['finish_reason']) and $data['finish_reason'] == 'stop') {
                    $currentWords = '';
                    $assistantMsg->content = $finalRes;
                    $assistantMsg->tokens += $currentTokens;
                    $assistantMsg->save();
                    Conversation::whereId($convId)->increment('total_tokens', $currentTokens);
                    $this->decreaseUserToken($userId, $version, $currentTokens);
                }

                event(new NewResponse(json_encode(['data' => $data, 'conv_id' => $convId, 'conv_uuid' => $convUUId]), $uuid));
            }
        } catch (Throwable $ex) {
            $errMsg = $ex->getMessage();
            Log::error($errMsg);
            Log::info(['user_id' => $userId, 'conv_id' => $convId, 'msg_id' => $assistantMsg->id, 'content' => $msg, 'res' => $finalRes]);
            if (Str::contains($errMsg, '400 Bad Request')) {
                $userMsg->delete();
                $assistantMsg->delete();
                $error = json_encode(['error' => 'LONG_TEXT']);
                event(new NewResponse(['data' => $error, 'conv_id' => $convId, 'conv_uuid' => $convUUId], $uuid));
            } else {
                event(new NewResponse(json_encode(['data' => ['error' => 'UNKNOWN_ERROR'], 'conv_id' => $convId, 'conv_uuid' => $convUUId]), $uuid));
            }
        }

        return;
    }

    // stop the conversation
    public function stop(Request $request) {
        $convId = $request->get('conv_id');
        $userId = auth()->user()->id;

        $lastConvAssistantMsg = ConversationMessage::query()
            ->whereRole('assistant')
            ->whereConversationId(function ($query) use ($userId, $convId) {
                $query->select('id')->from('conversations')->whereUserId($userId)->whereId($convId);
            })
            ->orderBy('id', 'desc')
            ->firstOrFail();

        $lastConvAssistantMsg->is_stop = true;
        $lastConvAssistantMsg->save();

        return response()->json([
            'result' => true,
            'data' => 'STOP'
        ]);
    }

    // get stream by version
    private function getStream($version, $messages, $toneId, $characterId, $aiId) {
        if ($version == 1) {
            return $this->apiService->getStreamResponse($messages, $toneId);
        } elseif ($version == 2) {
            return $this->apiService->getStreamResponseV2($messages, $characterId);
        } elseif ($version == 3) {
            return $this->apiService->getStreamResponseV3($messages, $aiId);
        }
    }

    // decrease user token base version
    private function decreaseUserToken($userId, $version, $currentTokens) {

        $decrease = 0;

        if ($version == 1) {
            $decrease = $currentTokens * 1;
        } else if ($version == 2) {
            $decrease = $currentTokens * 15;
        } else if ($version == 3) {
            $decrease = $currentTokens * 20;
        }

        UserToken::whereUserId($userId)->decrement('remaining_tokens', $decrease);
    }
}
