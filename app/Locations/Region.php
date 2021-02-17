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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name->toArray(),
            'areas' => $this->areas->map->toArray(),
        ];
    }

    public function presentForLang($lang)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->in($lang),
            'areas' => $this->areas->map->presentForLang($lang)
        ];
    }

    public function fullName($lang)
    {
        return sprintf("%s, %s", $this->name->in($lang), $this->country->name->in($lang));
    }
}
