<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DevelopersSeeder extends Seeder
{
    /**
     * Developers Seeder'i çalıştırır
     */
    public function run(): void
    {
        $developers = json_decode(file_get_contents(base_path('storage/json/developers.json')), true);
        foreach ($developers as $developer) {
            Developer::create($developer);
        }
    }
}
