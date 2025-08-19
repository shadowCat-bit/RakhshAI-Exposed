<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {

    protected $appends = ['logo_img'];

    public function getLogoImgAttribute() {

        return asset('assets/images/main/' . $this->image);
    }
}
