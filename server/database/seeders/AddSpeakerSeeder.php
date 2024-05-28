<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Review;
use App\Models\Speaker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddSpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $speaker = new Speaker();
        $speaker->firstName = "Hide";
        $speaker->lastName = "Kojima";
        $speaker->imgUrl = "/storage/img/OlLfAJsPleaqJB8tAcQEzzEFxMHlmRbiRHFRvEj1.jpg";
        $speaker->description = "Hideo Kojima is a Japanese video game designer. He is regarded as an auteur of video games. In 1986, he was hired by Konami, for which he designed and wrote Metal Gear (1987) for the MSX2, a game that laid the foundations for stealth games and the Metal Gear series, his best known and most appreciated works.";
        $speaker->descriptionShort = "Hideo Kojima is a Japanese video game designer.";
        $speaker->xFormerlyKnownAsTwitterProfile = "https://twitter.com/HIDEO_KOJIMA_EN";
        $speaker->facebookProfile = "https://www.instagram.com/hideo_kojima";
        $speaker->personalPage = "https://www.kojimaproductions.jp/en";
        $speaker->save();
    }
}
