<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\PublicMessage;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller {

    // chat list
    public function list(Request $request) {
        $userId = $request->get('user_id');
        $convId = $request->get('conv_id');
        $convMessages = [];

        if (!$convId) {
            $convId = Conversation::query()
                ->withTrashed()
                ->whereUserId($userId)
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
            ->whereUserId($userId)
            ->orderBy('id', 'desc')
            ->get();

        $user = User::query()
            ->whereId($userId)
            ->first();

        return view('admin.chats.chats', compact('user', 'convMessages', 'convs'));
    }

    // public chat list
    public function public(Request $request) {
        $messages = PublicMessage::query()
            ->orderBy('id', 'asc')
            ->paginate(200);

        return view('admin.chats.public', compact('messages'));
    }
}
