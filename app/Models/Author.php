<?php

namespace App\Models;

use App\Models\Tenant\TenantModel;

class Author extends TenantModel
{
    protected $fillable = [
        'name',
        'library_id',
    ];
}

