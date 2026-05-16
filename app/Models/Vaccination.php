<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Vaccination extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vaccinations';

    protected $fillable = [
        'user_id',
        'livestock_id',
        'vaccine_name',
        'date_given',
        'next_due_date',
        'administered_by',
        'notes',
    ];

    protected $casts = [
        'date_given'    => 'datetime',
        'next_due_date' => 'datetime',
    ];

    public function livestock()
    {
        return $this->belongsTo(Livestock::class, 'livestock_id');
    }

    // Scope — farmer sees only own vaccinations
    public function scopeForUser($query)
    {
        if (auth()->user()->role === 'farmer') {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
}