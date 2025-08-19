<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ExploreController extends Controller {

    // explore page
    public function explore(Request $request) {
        $images = Image::query()
            ->wherePublicShow(true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('explore', compact('images'));
    }

    // explore single page
    public function single(request $request, $uuid) {
        $img = Image::query()
            ->with(['user'])
            ->wherePublicShow(true)
            ->whereUuid($uuid)
            ->firstOrFail();

        $otherImg = Image::query()
            ->whereUserId($img->user->id)
            ->where('id', '!=', $img->id)
            ->wherePublicShow(true)
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();

        return view('single-image', compact('img', 'otherImg'));
    }

    // get other image from 
    public function otherImages(request $request) {
        $uuid = $request->get('uuid');

        $img = Image::query()
            ->whereUuid($uuid)
            ->firstOrFail();

        $otherImgs = Image::query()
            ->whereUserId($img->user_id)
            ->where('id', '!=', $img->id)
            ->wherePublicShow(true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json([
            'other_imgs' => $otherImgs
        ]);
    }
}
