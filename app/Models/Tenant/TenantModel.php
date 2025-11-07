<?php

namespace App\Models\Tenant;

use App\Models\Library;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\LibraryScope;

abstract class TenantModel extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new LibraryScope);
        static::creating(function ($model) {
            if (app()->has('library')) {
                $library = app('library');
                $model->library_id = $library->id;
            }
        });
    }

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    public function getCreatedAtAttribute($val)
    {
        return date('Y/m/d - H:i A', strtotime($val));
    }
}
