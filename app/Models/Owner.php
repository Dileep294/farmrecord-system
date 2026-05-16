<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Owner extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'owners';

    protected $fillable = [
        'user_id',
        'name',
        'nic',
        'phone',
        'address',
        'email',
    ];

    public function livestock()
    {
        return $this->hasMany(Livestock::class, 'owner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}