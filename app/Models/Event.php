<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'date',
        'location',
        'max_participants',
        'organizer_id',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Scopes pour les types d'événements
    public function scopeWorkshops($query)
    {
        return $query->where('type', 'atelier');
    }

    public function scopeConferences($query)
    {
        return $query->where('type', 'conférence');
    }

    public function scopeCollections($query)
    {
        return $query->where('type', 'collecte');
    }

    // Scopes pour les statuts
    public function scopePlanned($query)
    {
        return $query->where('status', 'planifié');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmé');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'annulé');
    }

    // Méthodes utilitaires
    public function getAvailableSpotsAttribute()
    {
        return $this->max_participants - $this->participations()->where('status', 'inscrit')->count();
    }

    public function isFull()
    {
        return $this->available_spots <= 0;
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participations', 'event_id', 'user_id')
                    ->withPivot('status', 'registration_date')
                    ->withTimestamps();
    }
}