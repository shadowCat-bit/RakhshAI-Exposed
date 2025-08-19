<?php

namespace App\Models;

use App\Events\UserPointEvent;
use Illuminate\Database\Eloquent\Model;

class Level extends Model {

    protected $guarded = [];

    // get level id based on points
    public static function getLevelIdBasedOnPoints($points) {
        if ($points > 999999999) {
            return 5;
        }

        return self::query()
            ->where('from', '<=', $points)
            ->where('to', '>=', $points)
            ->value('id');
    }

    // init user levels
    public function initUserLevels() {

        User::chunk(1000, function ($users) {

            foreach ($users as $user) {

                $alreadyExists = UserPointItem::query()
                    ->whereUserId($user->id)
                    ->wherePointId(function ($query) {
                        $query->select('id')->from('points')->whereType('register');
                    })
                    ->exists();

                if ($alreadyExists) {
                    continue;
                }

                event(new UserPointEvent($user, null, 'register'));

                $trs = Transaction::query()
                    ->whereUserId($user->id)
                    ->whereTrStatus('success')
                    ->get();

                foreach ($trs as $tr) {
                    $pointType = 'purchase_package_' . $tr->package_id;
                    event(new UserPointEvent($user, null, $pointType));
                }
            }
        });
    }
}
