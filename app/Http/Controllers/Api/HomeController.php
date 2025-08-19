<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller {


    public function slider() {

        return response()->json([
            'slider' => [
                ['img' => 'https://rakhshai.com/assets/images/slider/slide1.webp', 'type' => 'noting', 'link' => '','title' => 'رخشای،اولین مدل
هوش مصنوعی ایرانی'],
                ['img' => 'https://rakhshai.com/assets/images/slider/slide2.webp', 'type' => 'external', 'link' => 'https://rakhshai.com/news/the-first-offline-persian-language-model-with-400-billion-parameters-zal-plus-llm/' , 'title' => 'مدل زبانی آفلاین
زال پلاس'],
                ['img' => 'https://rakhshai.com/assets/images/slider/slide3.webp', 'type' => 'external', 'link' => 'https://rakhshai.com/news/about-zal-3-ai/' , 'title' => 'هوش مصنوعی تو
زال 3']
            ]
        ]);
    }
}
