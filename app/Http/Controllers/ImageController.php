<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImageToServer(Request $request)
    {
        $imageData = $request->input('image_data');
        $imageExtracted = json_decode($imageData);
        $nameOfImage = 'image_' . time() . '.png';
        file_put_contents(public_path('img/' . $nameOfImage), $imageExtracted);
    }
}
