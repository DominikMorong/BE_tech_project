<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function createGalleryCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:64',
        ]);

        $galleryCategory = GalleryCategory::create($validatedData);

        return response()->json([
            'message' => 'Gallery category created successfully',
            'data' => $galleryCategory
        ], 201);
    }

    public function createGallery(Request $request)
    {
        $validatedData = $request->validate([
            'imgUrl' => 'required|max:512',
            'gallery_category_id' => 'required|exists:gallery_categories,id',
        ]);

        $gallery = Gallery::create($validatedData);

        return response()->json([
            'message' => 'Gallery created successfully',
            'data' => $gallery
        ], 201);
    }

    public function getCategories()
    {
        $categories = GalleryCategory::all();
    
        return response()->json([
            'message' => 'Retrieved successfully',
            'data' => $categories
        ], 200);
    }

    public function getGalleryByGalleryCategoryId($id)
    {
        $galleries = Gallery::where('gallery_category_id', $id)->get();

        if ($galleries->isEmpty()) {
            return response()->json([
                'message' => 'No galleries found for this category'
            ], 404);
        }

        return response()->json([
            'message' => 'Retrieved successfully',
            'data' => $galleries
        ], 200);
    }

}
