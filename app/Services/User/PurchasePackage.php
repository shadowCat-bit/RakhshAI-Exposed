<?php

namespace App\Services\User;

use App\Models\GivenToken;
use App\Models\TokenPackage;
use App\Models\Transaction;
use App\Models\UserToken;

class PurchasePackage {

    // after successful package payment
    public function afterSuccessfulPackagePayment($userId, $packageId) {
        $purchasedPackage = TokenPackage::whereId($packageId)->firstOrFail();
        $this->updateOrStoreUserTokens($userId, $purchasedPackage);
        $this->storeGivenToken($userId, $purchasedPackage);
    }

    // update transaction status to success
    public function updateTransactionStatus($trId, $userId, $packageId, $amount) {
        return Transaction::query()
            ->whereId($trId)
            ->whereUserId($userId)
            ->wherePackageId($packageId)
            ->whereTrAmount($amount)
            ->whereTrStatus('pending')
            ->update(['tr_status' => 'success']);
    }

    // update user_tokens (remaining_tokens) or store new one
    private function updateOrStoreUserTokens($userId, $purchasedPackage) {
        $currentTokens = UserToken::query()
            ->whereUserId($userId)
            ->first();
        if ($currentTokens) {
            $currentTokens->remaining_tokens += $purchasedPackage->tokens;
            $currentTokens->save();
        } else {
            $currentTokens = UserToken::create([
                'user_id' => $userId,
                'remaining_tokens' => $purchasedPackage->tokens
            ]);
        }

        return [
            'result' => true,
            'data' => $currentTokens
        ];
    }

    // store given token for user
    private function storeGivenToken($userId, $purchasedPackage) {
        GivenToken::create([
            'user_id' => $userId,
            'type' => 'package',
            'tokens' => $purchasedPackage->tokens
        ]);

        return [
            'result' => true
        ];
    }
}
