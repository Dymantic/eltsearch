<?php


namespace App\Schools;


use Illuminate\Database\Eloquent\Relations\Pivot;

class SchoolUser extends Pivot
{
    protected $casts = ['owner' => 'boolean'];
}
