<?php

namespace App\Http\Requests;

use App\Announcements\AnnouncementInfo;
use App\Rules\TranslationField;
use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'body' => [new TranslationField()],
            'starts' => ['date'],
            'ends' => ['date', 'after_or_equal:starts'],
        ];
    }

    public function announcementInfo(): AnnouncementInfo
    {
        return new AnnouncementInfo($this->all([
            'body',
            'starts',
            'ends',
        ]));
    }
}
