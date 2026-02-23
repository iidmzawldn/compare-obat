<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | ROLE HELPERS
    |--------------------------------------------------------------------------
    | Helper supaya pengecekan role lebih rapi
    */

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isVendor()
    {
        return $this->hasRole('vendor');
    }

    public function isFarmasi()
    {
        return $this->hasRole('farmasi');
    }
}
