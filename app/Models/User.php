<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'role_id',
        'last_login',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relations
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'created_by');
    }

    public function partners()
    {
        return $this->hasMany(Partner::class, 'created_by');
    }

    public function collectionPoints()
    {
        return $this->hasMany(CollectionPoint::class, 'responsible_user_id');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'depositor_user_id');
    }

    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    // Méthodes utilitaires
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function isContributor()
    {
        return $this->role->name === 'contributeur';
    }

    public function isVisitor()
    {
        return $this->role->name === 'visiteur';
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
}