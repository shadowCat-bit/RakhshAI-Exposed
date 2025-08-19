<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\User;
use App\Models\UserAi;
use Illuminate\Http\Request;

class UserAiController extends Controller {

    public function list() {

        $userAis = UserAi::query()
            ->withTrashed()
            ->orderBy('id', 'desc')
            ->paginate(10);

        $aiCounts = UserAi::withTrashed()->count();

        return view('admin.user-ais.list', compact('userAis', 'aiCounts'));
    }

    public function show(Request $request) {

        $userId = $request->get('user_id');
        $convId = $request->get('conv_id');
        $aiId = $request->get('ai_id');
        $convMessages = [];

        if (!$convId) {
            $convId = Conversation::query()
                ->withTrashed()
                ->whereAiId($aiId)
                ->orderBy('id', 'desc')
                ->value('id');
        }
        if ($convId) {
            $convMessages = ConversationMessage::query()
                ->whereConversationId($convId)
                ->orderBy('id', 'asc')
                ->get();
        }
        $convs = Conversation::query()
            ->withTrashed()
            ->whereAiId($aiId)
            ->orderBy('id', 'desc')
            ->get();

        $user = User::query()
            ->whereId($userId)
            ->first();

        $userAi = UserAi::select(['id', 'ai_title', 'ai_avatar'])
            ->withTrashed()
            ->whereId($aiId)
            ->first();

        return view('admin.user-ais.chats', compact('user', 'convMessages', 'convs', 'userAi'));
    }
}
