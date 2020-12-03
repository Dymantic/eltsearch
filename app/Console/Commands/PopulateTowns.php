<?php

namespace App\Console\Commands;

use App\Locations\Country;
use App\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateTowns extends Command
{

    protected $signature = 'locations:towns';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        DB::table('countries')->truncate();
        DB::table('regions')->truncate();
        DB::table('areas')->truncate();

        $taiwan = collect(json_decode(file_get_contents(storage_path('taiwan-towns.json')), true));

        $tw = Country::new(new Translation(['en' => "Taiwan", 'zh' => "台灣"]));

        $taiwan->each(function($areas, $region) use ($tw) {
            $r = $tw->addRegion(new Translation(['en' => $region, 'zh' => "$region"]));

            foreach($areas as $area) {
                $r->addArea(new Translation(['en' => $area['en'], 'zh' => $area['zh']]));
            }
        });
    }
}
