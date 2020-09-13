<?php

namespace App\Locations;

use App\Translation;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name'];

    protected $casts = ['name' => Translation::class];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function rename(Translation $name)
    {
        $this->name = $name;
        $this->save();
    }

    public function toArray()
    {
        return [
            'id'   => $this->id,
            'name' => $this->name->toArray(),
        ];
    }

    public function presentForLang($lang)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name->in($lang),
        ];
    }

    public function fullName($lang): string
    {
        $region = $this->region;
        $country = $region->country;

        return sprintf("%s, %s, %s", $this->name->in($lang), $region->name->in($lang), $country->name->in($lang));
    }
}
