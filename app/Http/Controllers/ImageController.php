<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadImageToServer(Request $request)
    {
        Log::debug($request);
        $imageData = $request->input('image_data');
        Log::debug($imageData);
        $imageExtracted = json_decode($imageData);
        $nameOfImage = 'image_' . time() . '.png';
        file_put_contents(public_path('img/' . $nameOfImage), $imageExtracted);
    }
}
