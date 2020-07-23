<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NonEmptyTranslation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        if(!is_array($value)) {
            return false;
        }

        if($this->missing($value, 'en') && $this->missing($value, 'zh')) {
            return false;
        }

        return true;
    }

    private function missing($value, $lang)
    {
        return !isset($value[$lang]) || empty($value[$lang]);
    }


    public function message()
    {
        return 'At least one translation is required for :attribute';
    }
}
