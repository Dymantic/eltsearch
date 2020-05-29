<?php

namespace App\Schools;

use App\User;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'address', 'user_id'];

    public function administrator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
