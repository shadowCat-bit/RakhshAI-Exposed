<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    // login user
    public function login(Request $request) {
        $credentials = $request->only('mobile', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->token = $user->createToken('RAKHSHAI_APP')->plainTextToken;
            return response()->json([
                'status' => true,
                'user' => $user,
            ]);
        }

        return response()->json([
            'status' => false,
            'user' => null
        ]);
    }
}
