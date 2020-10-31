<?php

namespace App\Rules;

use App\Locations\Country;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueTranslation implements Rule
{
    public string $table;
    public string $column;
    public ?int $ignore;

    public function __construct(string $table, string $column, int $ignore = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignore = $ignore;
    }

    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false;
        }


        $query = DB::table($this->table)
                   ->where('id', '<>', $this->ignore)
                   ->where(function ($query) use ($value) {
                       foreach ($value as $lang => $input) {
                           $query->orWhere(DB::raw("lower(json_unquote(json_extract({$this->column}, '$.{$lang}')))"),
                               'LIKE', strtolower($input));

                       }
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
