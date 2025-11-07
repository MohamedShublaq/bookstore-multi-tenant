<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class BelongsToLibrary implements ValidationRule
{
    protected string $table;
    protected string $column;
    protected ?int $libraryId;

    public function __construct(string $table, string $column = 'id')
    {
        $this->table     = $table;
        $this->column    = $column;
        $this->libraryId = app()->has('library') ? app('library')->id : null;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->libraryId) {
            $fail('No library context found.');
            return;
        }

        $exists = DB::table($this->table)
            ->where($this->column, $value)
            ->where('library_id', $this->libraryId)
            ->exists();

        if (!$exists) {
            $fail("The selected {$attribute} does not belong to the current library.");
        }
    }
}
