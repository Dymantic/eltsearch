<?php

namespace App\Schools;

use App\Translation;
use Illuminate\Database\Eloquent\Model;

class SchoolType extends Model
{
    protected $fillable = ['name'];

    protected $casts = ['name' => Translation::class];

    public static function new(Translation $name): self
    {
        return self::create([
            'name' => $name
        ]);
    }

    public function rename(Translation $name)
    {
        $this->name = $name;
        $this->save();
    }
}
