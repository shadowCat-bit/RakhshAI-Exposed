<?php

namespace App\Listeners;

use App\Models\Level;
use App\Models\Point;
use App\Models\User;
use App\Models\UserLevel;
use App\Models\UserPointItem;

class UserPointListener {

    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void {
        $user = $event->user;
        $point = Point::whereType($event->pointType)->first();

        if (!$user) {
            $user = User::find($event->userId);
        }

        UserPointItem::create([
            'user_id' => $user->id,
            'point_id' => $point->id,
            'point_value' => $point->value
        ]);

        $userLevel = UserLevel::whereUserId($user->id)->first();
        if (!$userLevel) {
            $userLevel = UserLevel::create([
                'user_id' => $user->id,
                'level_id' => Level::getLevelIdBasedOnPoints($point->value),
                'total_points' => $point->value
            ]);
        } else {
            $userLevel->total_points += $point->value;
            $userLevel->level_id = Level::getLevelIdBasedOnPoints($userLevel->total_points);
            $userLevel->save();
        }
    }
}
