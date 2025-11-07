<?php

namespace App\Models;

use App\Models\Scopes\LibraryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([LibraryScope::class])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'library_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}
