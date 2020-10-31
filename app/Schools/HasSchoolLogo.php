<?php


namespace App\Schools;


use Illuminate\Http\UploadedFile;

trait HasSchoolLogo
{

    public function getLogo($default = '')
    {
        $logo = $this->getFirstMedia(School::LOGOS);

        return optional($logo)->getUrl('thumb') ?? $default;
    }

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
