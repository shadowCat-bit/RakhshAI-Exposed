<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function userDataHome() {

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'remaining_tokens' => UserToken::whereUserId($user->id)->value('remaining_tokens')
        ]);
    }
}
