<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Trade extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'trade_records';

    protected $fillable = [
        'user_id',
        'livestock_id',
        'from_owner_id',
        'to_owner_id',
        'transfer_date',
        'price',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
        'price'         => 'float',
    ];

    public function livestock()
    {
        return $this->belongsTo(Livestock::class, 'livestock_id');
    }

    // Scope — farmer sees only own trades
    public function scopeForUser($query)
    {
        if (auth()->user()->role === 'farmer') {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
}