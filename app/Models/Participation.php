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
    public function scopePending($query)   // en attente
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query) // confirmé
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query) // annulé
    {
        return $query->where('status', 'cancelled');
    }
}
