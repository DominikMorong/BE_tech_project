<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryCategory = new GalleryCategory();
        $galleryCategory->name = "2024";
        $galleryCategory->save();

        $gallery = new Gallery();
        $gallery->imgUrl = "/storage/img/I23HlMPy4H5ZK102ipDhyuWQWBSUX400i3LTXfwN.jpg";
        $gallery->gallery_category_id = 1;
        $gallery->save();
    }
}
