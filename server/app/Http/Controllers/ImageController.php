<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function saveImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'Validation error',
                'erroes' => $validator->errors()
            ], 403);
        }

        $uploadFolder = 'img';

        $image = $request->file('image');

        $image_uploaded_path = $image->store($uploadFolder, 'public');
        
        return response()->json([
            'message' => 'Image uploaded',
            'imgUrl' => str_replace(url('/'), '', Storage::url($image_uploaded_path))
        ], 201);

    }

}
