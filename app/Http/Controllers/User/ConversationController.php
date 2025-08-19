<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\UserToken;
use Illuminate\Http\Request;

class ConversationController extends Controller {

    // return user conversation list.
    public function list() {
        $userId = auth()->user()->id;
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

        return response()->json($convs);
    }

    // delete conversation by id
    public function delete(Request $request) {
        $userId = auth()->user()->id;
        $convId = $request->get('id');
        Conversation::query()
            ->whereId($convId)
            ->whereUserId($userId)
            ->delete();

        return response()->json([
            'result' => true,
        ]);
    }

    // delete all conversations
    public function deleteAll() {
        $userId = auth()->user()->id;
        Conversation::query()
            ->whereUserId($userId)
            ->whereIsPinned(false)
            ->delete();

        return response()->json([
            'result' => true,
        ]);
    }

    // return conversation messages
    public function conversationMessages(Request $request) {
        $convId = $request->get('id');
        $userId = auth()->user()->id;
        if (!Conversation::whereId($convId)->whereUserId($userId)->exists()) {
            return response()->json([]);
        }
        $messages = ConversationMessage::query()
            ->whereConversationId($convId)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($messages);
    }

    // pin the conversation
    public function pin(Request $request) {
        $convId = $request->get('id');
        $userId = auth()->user()->id;
        $conv = Conversation::whereId($convId)->whereUserId($userId)->first();
        $conv->is_pinned = ($conv->is_pinned == 0) ? 1 : 0;
        $conv->save();

        return response()->json([
            'result' => true,
            'data' => $conv->is_pinned == 0 ? 'UNPIN' : 'PIN'
        ]);
    }

    // change conv title
    public function changeTitle(Request $request) {
        $convId = $request->get('id');
        $userId = auth()->user()->id;
        $title = $request->get('title');
        Conversation::whereId($convId)->whereUserId($userId)->update(['title' => $title]);

        return response()->json([
            'result' => true,
        ]);
    }

    // return user remaining tokens
    public function remainingTokens(Request $request) {
        $userId = auth()->user()->id;
        $tokens = UserToken::whereUserId($userId)->first();

        return response()->json([
            'result' => true,
            'data' => $tokens
        ]);
    }
}
