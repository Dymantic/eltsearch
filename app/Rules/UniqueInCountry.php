<?php

namespace App\Rules;

use App\Locations\Country;
use Illuminate\Contracts\Validation\Rule;

class UniqueInCountry implements Rule
{

    private Country $country;
    private ?int $ignore;

    public function __construct(Country $country, int $ignore = null)
    {
        $this->country = $country;
        $this->ignore = $ignore;
    }


    public function passes($attribute, $value)
    {
        if(!is_array($value)) {
            return false;
        }

        $query = $this->country
            ->regions()
            ->where('id', '<>', $this->ignore)
            ->where(function($query) use ($value) {
                collect($value)->each(function ($input, $lang) use ($query) {
                    $query->orWhere("name->{$lang}", 'LIKE', $input);
                });
            });

        return $query->count() === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
