<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model {

    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['final_txt'];

    const originalFormat = '.jpg';

    // every image has user_id that belongs to user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // get the value of the img attribute.
    public function getImgAttribute($value) {
        if (is_null($value)) {
            return null;
        }

        $imgArr = unserialize($value);
        foreach ($imgArr as $key => $img) {
            $thumbnail = rtrim($img, self::originalFormat) . '-thumbnail.jpg';
            $imgArr[$key] = [
                'original' => url('images/' . $img),
                'thumbnail' => url('images/' . $thumbnail)
            ];
        }

        return $imgArr;
    }

    // set the value of the img attribute.
    public function setImgAttribute($value) {
        if (is_null($value)) {
            $this->attributes['img'] = null;
        }

        $this->attributes['img'] = serialize($value);
    }

    // get the value of the prompt attribute.
    public function getPromptAttribute($value) {
        if (is_null($value)) {
            return null;
        }

        return unserialize($value);
    }

    // set the value of the prompt attribute.
    public function setPromptAttribute($value) {
        if (is_null($value)) {
            $this->attributes['prompt'] = null;
        }

        $this->attributes['prompt'] = serialize($value);
    }
}
