<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

// TODO fix validation
class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|max:64',
            'img' => 'required|max:512',
        ]);

        $review = Review::create($validatedData);

        return response()->json([
            'message' => 'Review created successfully',
            'data' => $review
        ], 201);
    }    

    public function getReview($id)
    {
        $review = Review::find($id);

        if ($review) {
            return response()->json([
                'message' => 'Retrieved successfully',
                'data' => $review
            ], 200);
        }

        return response()->json([
            'message' => 'Review not found'
        ], 404);
    }

    public function updateReview(Request $request, $id)
    {
        $review = Review::find($id);

        if ($review) {
            $validatedData = $request->validate([
                'text' => 'required|max:64',
                'img' => 'required|max:512',
            ]);

            $review->update($validatedData);

            return response()->json([
                'message' => 'Review updated successfully',
                'data' => $review
            ], 200);
        }

        return response()->json([
            'message' => 'Review not found'
        ], 404);
    }

    public function deleteReview($id)
    {
        $review = Review::find($id);

        if ($review) {
            $review->delete();

            return response()->json([
                'message' => 'Review deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Review not found'
        ], 404);
    }

    public function getReviews()
    {
        $reviews = Review::all();

        return response()->json([
            'message' => 'Retrieved successfully',
            'data' => $reviews
        ], 200);
    }
}
