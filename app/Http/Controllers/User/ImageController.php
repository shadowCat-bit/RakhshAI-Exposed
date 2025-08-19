<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\UserToken;
use App\Services\ChatGPT\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller {

    private $imageService;

    public function __construct() {
        $this->imageService = new ImageService();
    }

    // image page
    public function index(Request $request, $imageUUId = null) {
        $user = auth()->user();
        $userId = $user->id;
        $user->is_first_login = $request->session()->get('first_login', 'no');
        $img = null;
        $images = Image::query()
            ->whereUserId($userId)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();
        if (!is_null($imageUUId)) {
            $img = Image::query()
                ->where('uuid', $imageUUId)
                ->whereUserId($userId)
                ->first();
        }
        $remainingTokens = UserToken::whereUserId($userId)->first();

        $canUserUseV2 = $this->imageService->canUserUseShahrzad2($userId);

        return view('user.image', compact('images', 'img', 'user', 'remainingTokens', 'canUserUseV2'));
    }

    // user images list
    public function list(Request $request) {
        $userId = auth()->user()->id;

        $images = Image::query()
            ->whereUserId($userId)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

        return response()->json($images);
    }

    // generate and store image in database
    public function store(Request $request) {
        $title = $request->get('title');
        $prompts = $request->get('propmts');
        $n = $request->get('n');
        $size = $request->get('size');
        $userId = auth()->user()->id;
        $publicShow = $request->get('public_show', true);
        $isPersian = $request->get('is_persian', true);
        $version = $request->get('version', 1);

        $tokenPerImage = $version == 1 ? ImageService::TokenPerImage : ImageService::TokenPerImageV2[$size];
        if (UserToken::whereUserId($userId)->where('remaining_tokens', '<', $tokenPerImage)->exists()) {
            return response()->json([
                'result' => false,
                'data' => 'NOT_ENOUGH_TOKENS'
            ]);
        }
        if ($version == 2) {
            $canUserUseShahrzad2 = $this->imageService->canUserUseShahrzad2($userId);
            if (!$canUserUseShahrzad2) {
                return response()->json([
                    'result' => false,
                    'data' => 'USER_CANNOT_USE_V2'
                ]);
            }
        }
        if (!$title or strlen($title) > 500) {
            return response()->json([
                'result' => false,
                'data' => 'INVALID_TITLE'
            ]);
        }
        if (!$n or !is_numeric($n) or $n > 4) {
            return response()->json([
                'result' => false,
                'data' => 'INVALID_N'
            ]);
        }
        if (!$size or !in_array($size, ['small', 'medium', 'large'])) {
            return response()->json([
                'result' => false,
                'data' => 'INVALID_SIZE'
            ]);
        }


        return $this->imageService->generateImage($title, $prompts, $n, $size, $userId, $publicShow, $isPersian, $version);
    }

    // add to public show or remove from public show
    public function publicShow(Request $request) {
        $imgId = $request->get('id');

        $img = Image::find($imgId);
        if (!$img) {
            return response()->json([
                'result' => false,
                'data' => 'INVALID_ID'
            ]);
        }
        $img->public_show = $img->public_show == 1 ? 0 : 1;
        $img->save();

        return response()->json([
            'result' => true,
            'data' => $img->public_show == 1 ? 'PUBLIC_SHOW' : 'NOT_PUBLIC_SHOW'
        ]);
    }

    // pin the image
    public function pin(Request $request) {
        $imageId = $request->get('id');
        $userId = auth()->user()->id;
        $img = Image::whereId($imageId)->whereUserId($userId)->first();
        $img->is_pinned = ($img->is_pinned == 0) ? 1 : 0;
        $img->save();

        return response()->json([
            'result' => true,
            'data' => $img->is_pinned == 0 ? 'UNPIN' : 'PIN'
        ]);
    }

    // delete image by id
    public function delete(Request $request) {
        $userId = auth()->user()->id;
        $imgId = $request->get('id');
        Image::query()
            ->whereId($imgId)
            ->whereUserId($userId)
            ->delete();

        return response()->json([
            'result' => true,
        ]);
    }

    // delete all images
    public function deleteAll() {
        $userId = auth()->user()->id;
        Image::query()
            ->whereUserId($userId)
            ->whereIsPinned(false)
            ->delete();

        return response()->json([
            'result' => true,
        ]);
    }
}
