<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model {

    use SoftDeletes;

    protected $guarded = [];

    public function conversationMessages() {
        return $this->hasMany(ConversationMessage::class);
    }

    public function tone() {
        return $this->belongsTo(Tone::class);
    }

    public function character() {
        return $this->belongsTo(Character::class);
    }

    public function userAi() {
        return $this->belongsTo(UserAi::class, 'ai_id');
    }
}
