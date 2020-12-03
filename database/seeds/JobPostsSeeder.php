<?php

namespace Database\Seeders;

use App\Locations\Area;
use App\Placements\JobPost;
use App\Schools\School;
use App\User;
use Illuminate\Database\Seeder;

class JobPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = Area::all()->pluck('id');
        $days = collect(range(1, 300));

        $schools = collect(range(1, 200))
            ->map(function($index) use ($areas, $days) {
                return factory(School::class)->create([
                    'area_id' => $areas->random(),
                    'created_at' => now()->subDays($days->random() * 3),
                ]);
            });

        foreach (range(1, 300) as $index) {
            $school = $schools->random();
            factory(JobPost::class)->create([
                'area_id' => $school->area_id,
                'first_published_at' => now()->subDays($days->random()),
                'school_id' => $school->id,
                'posted_by' => 1,
                'last_edited_by' => 1,
            ]);
        }
    }
}
