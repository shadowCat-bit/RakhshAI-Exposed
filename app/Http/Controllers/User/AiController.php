<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAi;
use App\Services\ChatGPT\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AiController extends Controller {

    private $apiService;

    public function __construct() {
        $this->apiService = new ApiService();
    }

    public function list() {

        $userId = auth()->user()->id;

        $userAiList = UserAi::query()
            ->select(['id', 'user_id', 'ai_title', 'ai_avatar', DB::raw('SUBSTRING(ai_content, 1, 100) as ai_content')])
            ->whereUserId($userId)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'result' => true,
            'data' => $userAiList
        ]);
    }

    public function store(Request $request) {

        $userId = auth()->user()->id;
        $aiTitle = $request->get('ai_title');
        $aiContent = $request->get('ai_content');
        $aiAvatar = $request->get('ai_avatar');

        if (!$aiTitle or ! $aiContent) {

            return response()->json([
                'result' => false,
                'message' => 'INVALID_PARAMS'
            ]);
        }

        if ($this->apiService->wordsCount($aiContent) > 10000) {

            return response()->json([
                'result' => false,
                'message' => 'LIMIT_LEN'
            ]);
        }

        $countUserAi = UserAi::query()
            ->whereUserId($userId)
            ->count();

        if ($countUserAi >= 5) {

            return response()->json([
                'result' => false,
                'message' => 'AI_LIMIT'
            ]);
        }


        $imageUrl = $this->uploadImg($aiAvatar);

        if (!$imageUrl['result']) {

            return response()->json([
                'result' => false,
                'message' => $imageUrl['error']
            ]);
        }

        $ai = UserAi::create([
            'user_id' => $userId,
            'ai_title' => $aiTitle,
            'ai_content' => $aiContent,
            'ai_avatar' => $imageUrl['url'],
        ]);

        return response()->json([
            'result' => true,
            'data' => $ai
        ]);
    }

    public function getAiById(Request $request) {

        $aiId = $request->get('ai_id');
        $userAi = auth()->user()->id;

        $ai = UserAi::query()
            ->whereUserId($userAi)
            ->whereId($aiId)
            ->first();

        return response()->json([
            'result' => true,
            'data' => $ai
        ]);
    }

    public function update(Request $request) {

        $userId = auth()->user()->id;
        $aiTitle = $request->get('ai_title');
        $aiContent = $request->get('ai_content');
        $aiId = $request->get('ai_id');
        $aiAvatar = $request->get('ai_avatar');

        if (!$aiTitle or ! $aiContent or !$aiId) {

            return response()->json([
                'result' => false,
                'message' => 'INVALID_PARAMS'
            ]);
        }

        if ($this->apiService->wordsCount($aiContent) > 10000) {

            return response()->json([
                'result' => false,
                'message' => 'LIMIT_LEN'
            ]);
        }


        $imageUrl = $this->uploadImg($aiAvatar);

        if (!$imageUrl['result']) {

            return response()->json([
                'result' => false,
                'message' => $imageUrl['error']
            ]);
        }

        $ai = UserAi::query()
            ->whereUserId($userId)
            ->whereId($aiId)
            ->first();

        $ai->ai_title = $aiTitle;
        $ai->ai_content = $aiContent;
        $ai->ai_avatar = $imageUrl['url'] ?? $ai->ai_avatar;
        $ai->save();

        return response()->json([
            'result' => true,
            'data' => $ai
        ]);
    }

    public function delete(Request $request) {

        $userId = auth()->user()->id;
        $aiId = $request->get('ai_id');

        if (!$aiId) {

            return response()->json([
                'result' => false,
                'message' => 'INVALID_PARAMS'
            ]);
        }

        UserAi::query()
            ->whereUserId($userId)
            ->whereId($aiId)
            ->delete();

        return response()->json([
            'result' => true,
        ]);
    }

    private function uploadImg($base64String) {

        $allowedExt = ['png', 'jpg', 'jpeg', 'webp', 'gif'];

        if (!$base64String) {
            return [
                'result' => true,
                'url' => null
            ];
        }

        $imageSize = strlen(base64_decode(explode(',', $base64String)[1]));

        if ($imageSize > 1 * 1024 * 1024) {
            return [
                'result' => false,
                'error' => 'SIZE_LIMIT'
            ];
        }

        list($type, $image) = explode(';', $base64String);

        list(, $image) = explode(',', $image);

        $extension = explode('/', $type)[1];

        if (!in_array($extension, $allowedExt)) {
            return [
                'result' => false,
                'error' => 'INVALID_FORMAT'
            ];
        }

        $image = base64_decode($image);

        $filename = Str::uuid() . '.' . $extension;

        Storage::disk('public')->put("uploads/{$filename}", $image);

        return [
            'result' => true,
            'url' => Storage::disk('public')->url("uploads/{$filename}")
        ];
    }
}
