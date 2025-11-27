<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'description',
        'area',
        'location',
        'rentFee',
        'isAvailable',
        'status',
        'bedrooms',
        'bathrooms',
        'floor',
    ];
    protected $casts = [
        'location' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(DepartmentImage::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorits');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 2);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }



    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = json_encode([
            'governorate' => $value['governorate'] ?? null,
            'city' => $value['city'] ?? null,
            'district' => $value['district'] ?? null,
            'street' => $value['street'] ?? null,
        ]);
    }
}
