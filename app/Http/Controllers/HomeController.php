<?php

namespace App\Http\Controllers;

use App\Models\ConversationMessage;
use App\Models\GivenToken;
use App\Models\Image;
use App\Models\PublicMessage;
use App\Models\User;
use App\Models\UserAi;
use App\Models\UserToken;
use App\Services\Blog\BlogPostService;
use Illuminate\Http\Request;

class HomeController extends Controller {

    // home page
    public function index(Request $request, BlogPostService $blogPostService) {

        $channel = md5($request->ip() . $request->userAgent());
        $messages = PublicMessage::whereChannel($channel)->orderBy('id', 'asc')->get();
        $maxChatExecuted = $messages->where('role', 'user')->count() >= 3;
        $remainingTokens = null;
        $countSection = [
            'users' => User::count(),
            'questions' => ConversationMessage::whereRole('user')->count(),
            'images' => Image::withTrashed()->count()
        ];
        $blogPosts = $blogPostService->getBlogPosts();
        if (auth()->check()) {
            $remainingTokens = UserToken::whereUserId(auth()->user()->id)->value('remaining_tokens');
        }
        $userAiCounts = UserAi::withTrashed()->count();

        return view('home', compact('channel', 'countSection', 'messages', 'maxChatExecuted', 'blogPosts', 'remainingTokens', 'userAiCounts'));
    }
}
