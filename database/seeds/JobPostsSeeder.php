<?php

namespace Database\Seeders;

use App\Locations\Area;
use App\Placements\JobPost;
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

        foreach (range(1, 300) as $index) {
            factory(JobPost::class)->create([
                'area_id' => $areas->random(),
                'first_published_at' => now()->subDays($days->random()),
                'posted_by' => 1,
                'last_edited_by' => 1,
            ]);
        }
    }
}
