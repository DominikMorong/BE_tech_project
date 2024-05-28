<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->text = "Very nice";
        $review->img = "/storage/img/OlLfAJsPleaqJB8tAcQEzzEFxMHlmRbiRHFRvEj1.jpg";
        $review->save();
    }
}
