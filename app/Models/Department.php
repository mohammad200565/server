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
        'size',
        'location',
        'rentFee',
        'isAvailable',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function images()
    {
        return $this->hasMany(DepartmentImage::class);
    }
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 2);
    }
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
