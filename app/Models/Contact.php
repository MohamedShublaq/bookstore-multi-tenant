<?php

namespace App\Models;

use App\Models\Tenant\TenantModel;

class Contact extends TenantModel
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'library_id',
    ];
}

