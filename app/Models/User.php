<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'personIdImage',
        'profileImage',
        'birthdate',
        'password',
        'user_id',
        'location',
        'verification_state',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'location' => 'array',
    ];
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(Department::class, 'favorites')->withTimestamps();
    }
}
