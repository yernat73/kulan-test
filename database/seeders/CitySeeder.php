<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    public function run()
    {
        $data = File::get(resource_path('data/kaz.json'));

        collect(json_decode($data, flags: JSON_UNESCAPED_UNICODE))
            ->values()
            ->pluck('name_ru')
            ->unique()
            ->each(fn (string $name) => City::query()->create(['name' => $name]));
    }
}
