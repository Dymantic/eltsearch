<?php


namespace App\Schools;


use Illuminate\Http\UploadedFile;

trait HasSchoolLogo
{
    public function setLogo(UploadedFile $upload)
    {
        $this->clearLogo();
        return $this
            ->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(School::LOGOS);
    }

    public function clearLogo()
    {
        $this->clearMediaCollection(School::LOGOS);
    }
}
