<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatGPT\ApiService;
use App\Events\NewResponseHome;
use App\Models\PublicMessage;
use Illuminate\Support\Facades\Log;
use Throwable;

class PublicChatController extends Controller {

    private $apiService;

    public function __construct() {
        $this->apiService = new ApiService();
    }


    // home page public chat
    public function publicChat(Request $request) {
        $msg = $request->get('content');
        $hash = md5($request->ip() . $request->userAgent());
        $error = null;

        if (is_null($msg)) {
            $error = json_encode(['error' => 'INVALID_PARAMETERS']);
        } elseif ($this->apiService->wordsCount($msg) > 2000) {
            $error = json_encode(['error' => 'LONG_TEXT']);
        } elseif (PublicMessage::whereChannel($hash)->whereRole('user')->count() >= 3) {
            $error = json_encode(['error' => 'MAX_CHAT_EXECUTED']);
        }

        if (!is_null($error)) {
            event(new NewResponseHome(['data' => $error], $hash));
            return;
        }

        PublicMessage::create([
            'channel' => $hash,
            'role' => 'user',
            'content' => $msg,
            'tokens' => $this->apiService->wordsCount($msg)
        ]);

        $messages = PublicMessage::select(['role', 'content'])
            ->whereChannel($hash)
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get()
            ->reverse()
            ->toArray();
        $messages = array_values($messages);

        $assistantMsg = PublicMessage::create([
            'channel' => $hash,
            'role' => 'assistant',
            'content' => '',
            'tokens' => 0
        ]);

        try {
            $stream = $this->apiService->getStreamResponse($messages);
            $finalRes = '';
            $currentWords = '';
            $currentTokens = 0;
            foreach ($stream as $res) {
                $data = $res->choices[0]->toArray();
                if (isset($data['delta']['content'])) {
                    $finalRes .= $data['delta']['content'];
                    $currentWords .= $data['delta']['content'];
                    $currentTokens = $this->apiService->wordsCount($currentWords);
                    if ($currentTokens >= 30) {
                        try {
                            $currentWords = '';
                            $assistantMsg->content = $finalRes;
                            $assistantMsg->tokens += $currentTokens;
                            $assistantMsg->save();
                        } catch (Throwable $ex) {
                            Log::error($ex->getMessage());
                        }
                    }
                } elseif (isset($data['finish_reason']) and $data['finish_reason'] == 'stop') {
                    $currentWords = '';
                    $assistantMsg->content = $finalRes;
                    $assistantMsg->tokens += $currentTokens;
                    $assistantMsg->save();
                }
                event(new NewResponseHome(json_encode(['data' => $data]), $hash));
            }
        } catch (Throwable $ex) {
            Log::error($ex->getMessage());
            event(new NewResponseHome(json_encode(['data' => ['error' => 'UNKNOWN_ERROR']]), $hash));
        }

        return;
    }
}
