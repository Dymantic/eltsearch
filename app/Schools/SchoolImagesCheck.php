<?php


namespace App\Schools;



use App\StatusCheck;

class SchoolImagesCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        return $this->school->getMedia(School::IMAGES)->count() < 4;
    }
}
