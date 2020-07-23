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
}
