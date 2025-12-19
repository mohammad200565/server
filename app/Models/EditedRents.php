<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditedRents extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'startRent',
        'endRent',
        'status',
        'rentFee',
    ];
    protected $attributes = [
        'status' => 'pending',
    ];

    public function original_Rent()
    {
        return $this->belongsTo(Rent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
