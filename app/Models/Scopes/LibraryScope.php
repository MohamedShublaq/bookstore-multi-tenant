<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LibraryScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->has('library')) {
            $library = app('library');
            $builder->where($model->qualifyColumn('library_id'), $library->id);
        }
    }
}
