<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranslationField implements Rule
{

    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        if(!is_array($value)) {
            return false;
        }

        foreach($value as $lang => $translation) {
            if(!is_string($lang)) {
                return false;
            }
        }

        return array_key_exists('en', $value) || array_key_exists('zh', $value);
    }


    public function message()
    {
        return 'The :attribute is required as a translation';
    }
}
