<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'capacity',
        'opening_hours',
        'responsible_user_id',
        'contact_info',
        'status'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relations
    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'point_id');
    }
}
