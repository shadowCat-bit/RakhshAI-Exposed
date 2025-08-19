<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Tone;
use App\Models\UserToken;
use App\Services\User\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller {

    // chat page
    public function index(Request $request, $convUUId = null) {
        $user = auth()->user();
        $userId = $user->id;
        $user->is_first_login = $request->session()->get('first_login', 'no');
        $convMsg = null;

        $convs = Conversation::query()
            ->with([
                'tone',
                'character',
                'userAi' => function ($query) {
                    $query->withTrashed()->select('id', 'user_id', 'ai_title', 'ai_avatar', 'deleted_at');
                }
            ])
            ->whereUserId($userId)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

        if (!is_null($convUUId)) {

            $conv = Conversation::with([
                'tone',
                'character',
                'userAi' => function ($query) {
                    $query->withTrashed()->select('id', 'user_id', 'ai_title', 'ai_avatar', 'deleted_at');
                }
            ])->where('uuid', $convUUId)->whereUserId($userId)->first();

            if ($conv) {
                $convMsg = ConversationMessage::query()
                    ->whereConversationId($conv->id)
                    ->orderBy('id', 'asc')
                    ->get();
            }
        }
        $remainingTokens = UserToken::whereUserId($userId)->first();

        $tones = Tone::query()
            ->select(['id', 'title', 'color'])
            ->orderBy('priority', 'asc')
            ->get();

        $characters = Character::query()
            ->select(['id', 'title', 'icon'])
            ->orderBy('priority', 'asc')
            ->get();

        $canUserUseZalv2 = (new ChatService)->canUserUseZalv2($userId);

        return view('user.chat', compact('convs', 'convMsg', 'user', 'remainingTokens', 'tones', 'characters', 'canUserUseZalv2'));
    }
}
