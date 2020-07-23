<?php

namespace App\Schools;

use App\UniqueKey;
use App\User;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'address', 'introduction', 'key', 'area_id'];

    protected $casts = ['area_id' => 'integer'];

    public static function new(string $name): self
    {
        return self::create([
            'name' => $name,
            'key' => UniqueKey::for('schools:key'),
        ]);
    }

    public function owners()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['owner'])
            ->as('team')
            ->using(SchoolUser::class);
    }

    public function setOwner(User $user)
    {
        $this->owners()->attach([$user->id => ['owner' => true]]);
    }

    public function schoolTypes()
    {
        return $this->belongsToMany(SchoolType::class);
    }

    public function updateProfile(SchoolProfileInfo $info)
    {
        $this->update([
            'name' => $info->name,
            'introduction' => $info->introduction,
            'area_id' => $info->area_id
        ]);

        $this->schoolTypes()->sync($info->types);
    }
}
