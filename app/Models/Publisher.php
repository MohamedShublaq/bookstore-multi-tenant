<?php

namespace App\Models;

use App\Models\Tenant\TenantModel;

class Publisher extends TenantModel
{
    protected $fillable = [
        'name',
        'library_id',
    ];
}
