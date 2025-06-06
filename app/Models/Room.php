<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'room_type',
        'room_floor',
        'status',
        'price_per_night',
        'capacity',
        'amenities',
        'image'
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    // Constantes pour les statuts
    const STATUS_AVAILABLE = 'Available';
    const STATUS_RESERVED = 'Reserved';
    const STATUS_OCCUPIED = 'Occupied';
    const STATUS_MAINTENANCE = 'Maintenance';

    // Constantes pour les types de chambres
    const ROOM_TYPES = [
        'Single rooms',
        'Double rooms',
        'Triple rooms',
        'Suite',
        'Deluxe',
        'Presidential Suite'
    ];

    // Obtenir tous les statuts disponibles
    public static function getStatuses()
    {
        return [
            self::STATUS_AVAILABLE,
            self::STATUS_RESERVED,
            self::STATUS_OCCUPIED,
            self::STATUS_MAINTENANCE
        ];
    }

    // Obtenir la couleur du badge selon le statut
    public function getStatusBadgeClass()
{
    return match($this->status) {
        'Disponible' => 'bg-success',
        'Occupée' => 'bg-danger',
        'En maintenance' => 'bg-warning',
        'Réservée' => 'bg-info',
        default => 'bg-secondary'
    };
}
public function reservationsActives()
{
    return $this->hasMany(Reservation::class)->where('statut', 'confirmee');
}

/**
 * Vérifier si la chambre est disponible pour une période donnée
 */
public function estDisponible($dateDebut, $dateFin)
{
    if ($this->statut !== 'disponible') {
        return false;
    }

    return !$this->reservations()
        ->where('statut', 'confirmee')
        ->where(function ($query) use ($dateDebut, $dateFin) {
            $query->where(function ($q) use ($dateDebut, $dateFin) {
                $q->where('date_checkin', '<=', $dateDebut)
                  ->where('date_checkout', '>', $dateDebut);
            })->orWhere(function ($q) use ($dateDebut, $dateFin) {
                $q->where('date_checkin', '<', $dateFin)
                  ->where('date_checkout', '>=', $dateFin);
            })->orWhere(function ($q) use ($dateDebut, $dateFin) {
                $q->where('date_checkin', '>=', $dateDebut)
                  ->where('date_checkout', '<=', $dateFin);
            });
        })
        ->exists();
}

/**
 * Scopes
 */
public function scopeDisponibles($query)
{
    return $query->where('statut', 'disponible');
}

public function scopeParType($query, $type)
{
    return $query->where('type', $type);
}


public function getTypeLibelleAttribute()
{
    $types = [
        'standard' => 'Standard',
        'deluxe' => 'Deluxe',
        'suite' => 'Suite'
    ];

    return $types[$this->type] ?? $this->type;
}
public function bookings()
{
    return $this->hasMany(Booking::class);
}

}
