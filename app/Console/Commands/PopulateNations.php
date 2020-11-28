<?php

namespace App\Console\Commands;

use App\Nation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateNations extends Command
{

    protected $signature = 'nations:populate';


    protected $description = 'Fill out all the possible nations';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path('countries.json')), true);

        DB::table('nations')->truncate();

        collect($data)->each(fn ($nation) => Nation::create([
            'iso_code' => $nation['alpha_2_code'],
            'name' => $nation['en_short_name'],
            'nationality' => $nation['nationality'],
        ]));
        return 0;
    }
}
