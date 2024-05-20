<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        try
        {
            Log::debug($request);
            $imageData = $request->file('part');
            Log::debug($imageData);
            //$imageExtracted = json_decode($imageData);
            $nameOfImage = 'image_' . time() . '.jpg';
            $imageData->move(public_path('img/'), $nameOfImage);

            return response()->json($nameOfImage);
        }
        catch (\Exception $e)
        {
            Log::debug($e);
            return response()->json("Something went wrong");
        }
    }
}
