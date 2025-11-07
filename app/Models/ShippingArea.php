<?php

namespace App\Models;

use App\Models\Tenant\TenantModel;

class ShippingArea extends TenantModel
{
    protected $fillable = [
        'name',
        'fee',
        'library_id',
    ];
}
