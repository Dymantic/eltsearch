<?php

namespace App\Placements;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMatch extends Model
{
    protected $fillable = ['job_post_id', 'job_search_id'];

    protected $casts = [
        'dismissed' => 'boolean'
    ];

    public function jobSearch()
    {
        return $this->belongsTo(JobSearch::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function searchingUser(): ?User
    {
        return $this->jobSearch->teacher->user ?? null;
    }

    public function dismiss()
    {
        $this->dismissed = true;
        $this->save();
    }
}
