<?php

namespace Database\Seeders;

use App\Locations\Area;
use App\Nation;
use App\Teachers\Teacher;
use Illuminate\Database\Seeder;

class TeachersSeeder extends Seeder
{

    public function run()
    {
        $nation_ids = Nation::all()->pluck('id');
        $areas = Area::all()->pluck('id');
        $days = collect(range(1,1000));

        foreach (range(1,700) as $index) {
            factory(Teacher::class)->create([
                'nation_id' => $nation_ids->random(),
                'area_id' => $areas->random(),
                'created_at' => now()->subDays($days->random()),
            ]);
        }
    }
}
