<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Livestock extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'livestock';

    protected $fillable = [
        'user_id',
        'owner_id',
        'tag_number',
        'species',
        'breed',
        'age',
        'colour',
        'status',
        'photo',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'livestock_id');
    }

    public function trades()
    {
        return $this->hasMany(Trade::class, 'livestock_id');
    }

    // Scope — farmer sees only own livestock
    public function scopeForUser($query)
    {
        if (auth()->user()->role === 'farmer') {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
}