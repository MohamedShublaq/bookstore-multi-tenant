<?php

namespace App\Models;

use App\Models\Scopes\LibraryScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([LibraryScope::class])]
class LibraryAdmin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'library_id',
        'name',
        'email',
        'password',
        'is_manager',
    ];

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getCreatedAtAttribute($val)
    {
        return date('Y/m/d - H:i A', strtotime($val));
    }
}
