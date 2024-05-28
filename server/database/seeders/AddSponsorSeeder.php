<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsor = new Sponsor();
        $sponsor->name = "Tesco";
        $sponsor->img = "/storage/img/HMjYz1qX5lJ7Mf9BzGWARpIvhnOyAbUhzJLXK5pW.jpg";
        $sponsor->url = "https://tesco.sk";
        $sponsor->save();
    }
}
