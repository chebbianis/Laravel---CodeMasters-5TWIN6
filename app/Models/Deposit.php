<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'point_id',
        'item_id',
        'depositor_user_id',
        'deposit_date',
        'quantity',
        'notes'
    ];

    protected $casts = [
        'deposit_date' => 'datetime',
    ];

    // Relations
    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class, 'point_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function depositor()
    {
        return $this->belongsTo(User::class, 'depositor_user_id');
    }
}
