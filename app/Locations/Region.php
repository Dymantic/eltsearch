<?php

namespace App\Locations;

use App\Translation;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name'];

    protected $casts = ['name' => Translation::class];

    public function rename(Translation $name)
    {
        $this->name = $name;
        $this->save();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function addArea(Translation $name): Area
    {
        return $this->areas()->create([
            'name' => $name,
        ]);
    }

    public function fullDelete()
    {
        $this->areas()->delete();
        $this->delete();
    }
}
