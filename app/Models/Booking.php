<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'check_in',
        'check_out',
        'nights',
        'price_per_night',
        'subtotal',
        'taxes',
        'total_price',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'price_per_night' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la chambre
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Accessor pour le nom complet
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Scope pour les réservations confirmées
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope pour les réservations actives (futures)
     */
    public function scopeActive($query)
    {
        return $query->where('check_in', '>=', now()->toDateString());
    }
}
