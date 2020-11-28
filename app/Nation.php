<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $fillable = ['iso_code', 'name', 'nationality'];
}
