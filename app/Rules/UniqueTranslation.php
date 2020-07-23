<?php

namespace App\Rules;

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
        if(!is_array($value)) {
            return false;
        }

        $query = DB::table($this->table)
                   ->where('id', '<>', $this->ignore)
            ->where(function($query) use ($value) {
                collect($value)->each(function($input, $lang) use ($query) {
                    $query->orWhere("{$this->column}->{$lang}", 'LIKE', $input);
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
