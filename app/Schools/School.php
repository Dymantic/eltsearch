<?php

namespace App\Schools;

use App\Locations\Area;
use App\Placements\JobPost;
use App\Placements\JobPostInfo;
use App\UniqueKey;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class School extends Model implements HasMedia
{
    use InteractsWithMedia, HasSchoolLogo;

    const MAX_IMAGES = 4;
    const LOGOS = 'logos';
    const IMAGES = 'images';

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

    public function area()
    {
        return $this->belongsTo(Area::class);
    }



    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 600, 600)
            ->optimize()
            ->performOnCollections(self::LOGOS, self::IMAGES);
    }

    public function hasMaxImages(): bool
    {
        return $this->getMedia(School::IMAGES)->count() >= School::MAX_IMAGES;
    }

    public function addImage(UploadedFile $upload): Media
    {
        return $this->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(self::IMAGES);
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

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function postJob(JobPostInfo $info, User $user): JobPost
    {
        $data = array_merge($info->toArray(), [
            'posted_by' => $user->id,
            'last_edited_by' => $user->id,
        ]);

        return tap($this->jobPosts()->create($data), function ($post) {
            $post->slug = UniqueKey::for('job_posts:slug');
            $post->save();
        });
    }
}
