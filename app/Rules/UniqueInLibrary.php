<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;
use Illuminate\Support\Facades\DB;

class UniqueInLibrary implements ValidationRule
{
    protected string $table;
    protected string $column;
    protected ?int $ignoreId;
    protected ?int $libraryId;

    public function __construct(string $table, string $column = 'email', ?int $ignoreId = null)
    {
        $this->table     = $table;
        $this->column    = $column;
        $this->ignoreId  = $ignoreId;
        $this->libraryId = app()->has('library') ? app('library')->id : null;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->libraryId) {
            $fail('No library context found.');
            return;
        }

        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->where('library_id', $this->libraryId);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail("The {$attribute} has already been taken in this library.");
        }
    }
}
