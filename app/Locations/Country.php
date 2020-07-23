<?php

namespace App\Locations;

use App\Translation;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];

    protected $casts = ['name' => Translation::class];

    public static function new(Translation $name): self
    {
        return static::create(['name' => $name]);
    }

    public function rename(Translation $name)
    {
        $this->name = $name;
        $this->save();
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function addRegion(Translation $region_name): Region
    {
        return $this->regions()->create([
            'name' => $region_name,
        ]);
    }

    public function fullDelete()
    {
        $this->regions->each(fn (Region $region) => $region->fullDelete());
        $this->delete();
    }
}
