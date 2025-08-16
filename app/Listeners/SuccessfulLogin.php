<?php

namespace App\Listeners;

use App\Models\Affiliate;
use App\Models\GivenToken;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Str;

class SuccessfulLogin {

    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void {
        $userId = $event->user->id;
        $isFromApp = $event->user->is_from_app ?? false;

        $this->storeRefCode($userId);

        if (!GivenToken::whereUserId($userId)->whereType('init')->exists() and !UserToken::whereUserId($userId)->exists()) {

            $initToken = $this->getInitTokens($userId);

            GivenToken::create([
                'user_id' => $userId,
                'type' => 'init',
                'tokens' => $initToken,
            ]);

            UserToken::create([
                'user_id' => $userId,
                'remaining_tokens' => $initToken
            ]);

            if (!$isFromApp) {
                request()->session()->flash('first_login', 'yes');
            }
        }
    }

    private function storeRefCode($userId) {

        $user = User::whereId($userId)->first();

        if ($user->ref_code) {
            return true;
        }

        $user->ref_code = Str::random(11);
        $user->save();

        return true;
    }

    private function getInitTokens($userId) {

        if (Affiliate::whereUserId($userId)->exists()) {
            return 10000;
        }

        return 5000;
    }
}
