<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    // change user name
    public function changeName(Request $request) {
        $userId = auth()->user()->id;

        User::whereId($userId)->update([
            'name' => $request->get('username')
        ]);

        return response()->json([
            'result' => true,
            'data' => User::find($userId)->value('name')
        ]);
    }
}
