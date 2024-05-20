<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        Log::debug($request->getRequestUri());
        try
        {
            Log::debug($request);
        $imageData = $request->file('part');
        Log::debug($imageData);
        //$imageExtracted = json_decode($imageData);
        $nameOfImage = 'image_' . time() . '.png';
        file_put_contents(public_path('img/' . $nameOfImage), $imageData);

        return response()->json($nameOfImage);
        }
        catch (\Exception $e)
        {
            Log::debug($e);
            return response()->json("Something went wrong");
        }
    }
}
