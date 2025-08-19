<?php

namespace App\Services\ChatGPT;

use App\Models\Image;
use App\Models\Option;
use App\Models\Transaction;
use App\Models\UserToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageServ;
use Throwable;

class ImageService {

    const SIZE = [
        'small' => '256x256',
        'medium' => '512x512',
        'large' => '1024x1024'
    ];

    const SIZEV2 = [
        'small' => '1024x1024',
        'medium' => '1024x1792',
        'large' => '1792x1024'
    ];

    const TokenPerImage = 1000;
    const TokenPerImageV2 = [
        'small' => 4000,
        'medium' => 8000,
        'large' => 8000,
    ];

    // generate image
    public function generateImage($title, $prompts, $n, $size, $userId, $publicShow, $isPersian, $version) {
        try {
            $apiKey = Option::where('key', 'api_key')->value('value');
            $client = OpenAI::factory()
                ->withApiKey($apiKey)
                ->withBaseUri('api.openai.com/v1')
                ->make();

            $textToGenerateImage = count($prompts) > 0 ? $title . ', ' . implode(', ', $prompts) : $title;
            $textToGenerateImage = ($isPersian or count($prompts) > 0) ? $this->trToEnglish($textToGenerateImage) : $textToGenerateImage;

            if (Str::contains(strtolower($textToGenerateImage), 'invalid') and Str::length($textToGenerateImage) < 10) {
                return [
                    'result' => false,
                    'data' => 'TRY_AGAIN',
                ];
            }

            if ($version == 1) {
                $sizeParam = self::SIZE[$size];
                $model = 'dall-e-2';
            } else {
                $sizeParam = self::SIZEV2[$size];
                $model = 'dall-e-3';
            }
            $result = $client->images()->create([
                'model' => $model,
                'prompt' => $textToGenerateImage,
                'n' => (int)$n,
                'size' => $sizeParam,
                'response_format' => 'url',
            ]);

            $folderName = date('Y-m-d');
            $uploadPath = Storage::path($folderName);
            if (!File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            $imagesArr = [];
            foreach ($result->data as $data) {
                $imgname = Str::uuid()->toString() . $userId . '-' . time();
                $imgPath = $uploadPath . '/' . $imgname . Image::originalFormat;
                if (ImageServ::make($data->url)->encode('jpg', 70)->save($imgPath)) {
                    $resizeW = 150;
                    $resizeH = 150;
                    if ($sizeParam == '1024x1792') {
                        $resizeW = 150;
                        $resizeH = 263;
                    } else if ($sizeParam == '1792x1024') {
                        $resizeW = 150;
                        $resizeH = 86;
                    }
                    $thumbnailPath = Storage::path($folderName . '/' . $imgname . '-' . 'thumbnail.jpg');
                    ImageServ::make($imgPath)
                        ->resize($resizeW, $resizeH)
                        ->encode('jpg', 70)
                        ->save($thumbnailPath);
                    array_push($imagesArr, $folderName . '/' . $imgname . Image::originalFormat);
                }
            }

            if (count($imagesArr) > 0) {
                $img = Image::create([
                    'uuid' => Str::uuid()->toString(),
                    'user_id' => $userId,
                    'title' => $title,
                    'prompt' => $prompts,
                    'final_txt' => $textToGenerateImage,
                    'img' => $imagesArr,
                    'size' => $size,
                    'public_show' => $publicShow,
                    'version' => $version
                ]);
                $this->decreaseUserToken($userId, count($imagesArr), $version, $size);
                return [
                    'result' => true,
                    'data' => $img,
                ];
            } else {
                return [
                    'result' => false,
                    'data' => 'TRY_AGAIN',
                ];
            }
        } catch (Throwable $ex) {
            Log::error($ex->getMessage());

            return [
                'result' => false,
                'data' => 'ERR',
                'msg' => $ex->getMessage()
            ];
        }
    }

    // check can user use shahrzad v2
    public function canUserUseShahrzad2($userId) {
        return Transaction::query()
            ->whereTrStatus('success')
            ->whereUserId($userId)
            ->exists();
    }

    // decrease user token after generate images
    private function decreaseUserToken($userId, $countImages, $version, $size) {
        if ($version == 1) {
            $decreaseTokens = self::TokenPerImage * $countImages;
        } else {
            $decreaseTokens = self::TokenPerImageV2[$size] * $countImages;
        }

        UserToken::whereUserId($userId)->decrement('remaining_tokens', $decreaseTokens);
    }

    // translate persian to english
    private function trToEnglish($text) {
        $apiKey = Option::where('key', 'api_key')->value('value');

        $client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('api.openai.com/v1')
            ->make();

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant that translates Persian text into English. Note that if part of the text is English and another part is Persian, just translate and remove the Persian and then return the translated text.'
                ],
                [
                    'role' => 'system',
                    'content' => 'If the text is about political figures of the Islamic Republic of Iran just return "INVALID"'
                ],
                [
                    'role' => 'system',
                    'content' => 'If the text is about sexual just return "INVALID"'
                ],
                [
                    'role' => 'user',
                    'content' => $text
                ]
            ],
        ]);

        return $result['choices'][0]['message']['content'];
    }
}
