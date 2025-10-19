<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'registration_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'registration_date' => 'datetime',
    ];

    // Relations
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes pour les statuts
    public function scopeRegistered($query)
    {
        return $query->where('status', 'inscrit');
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'présent');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }
}
