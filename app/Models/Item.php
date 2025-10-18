<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'condition',
        'image_url',
        'status',
         'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes pour les conditions
    public function scopeGoodCondition($query)
    {
        return $query->where('condition', 'bon');
    }

    public function scopeAverageCondition($query)
    {
        return $query->where('condition', 'moyen');
    }

    public function scopeToRepair($query)
    {
        return $query->where('condition', 'à réparer');
    }

    // Scopes pour les statuts
    public function scopeAvailable($query)
    {
        return $query->where('status', 'disponible');
    }

    public function scopeTransformed($query)
    {
        return $query->where('status', 'transformé');
    }

    public function scopeRecycled($query)
    {
        return $query->where('status', 'recyclé');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
}