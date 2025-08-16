<?php

namespace App\Observers;

use App\Events\UserPointEvent;
use App\Models\User;

class UserObserver {

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void {
        event(new UserPointEvent($user, null, 'register'));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void {
        //
    }
}
