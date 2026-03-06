<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'speaker',
        'location',
        'total_seats',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'registrations')->withTimestamps();
    }
}
