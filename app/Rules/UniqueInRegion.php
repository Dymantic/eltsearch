<?php

namespace App\Rules;

use App\Locations\Area;
use App\Locations\Region;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueInRegion implements Rule
{
    public Region $region;
    public ?int $ignore;

    public function __construct(Region $region, int $ignore = null)
    {
        $this->region = $region;
        $this->ignore = $ignore;
    }

    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false;
        }

        $query = $this
            ->region
            ->areas()
            ->where('id', '<>', $this->ignore)
            ->where(function ($query) use ($value) {
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
        return sprintf("That name already exists in the region %s", $this->region->name->in('en'));
    }
}
