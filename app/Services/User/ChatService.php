<?php

namespace App\Services\User;

use App\Models\Transaction;

class ChatService {

    // check can user use zal v2
    public function canUserUseZalv2($userId) {

        return true;

        // return Transaction::query()
        //     ->whereTrStatus('success')
        //     ->whereUserId($userId)
        //     ->exists();
    }
}
