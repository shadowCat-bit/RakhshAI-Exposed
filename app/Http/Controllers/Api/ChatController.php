<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Tone;
use App\Models\UserToken;
use App\Services\User\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller {

    // chat page
    public function index(Request $request) {
        $user = auth()->user();
        $userId = $user->id;
        $convMsg = null;

        $convs = Conversation::query()
            ->with(['tone', 'character'])
            ->whereUserId($userId)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

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

        return response()->json([
            'convs' => $convs,
            'convMsg' => $convMsg,
            'user' => $user,
            'remainingTokens' => $remainingTokens,
            'tones' => $tones,
            'characters' => $characters,
            'canUserUseZalv2' => $canUserUseZalv2,
        ]);
    }
}
