<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'chambre_id',
        'prenom',
        'nom',
        'telephone',
        'email',
        'date_checkin',
        'date_checkout',
        'nombre_adultes',
        'nombre_enfants',
        'prix_total',
        'statut',
        'commentaires',
        'methode_paiement'
    ];

    protected $casts = [
        'date_checkin' => 'date',
        'date_checkout' => 'date',
        'prix_total' => 'decimal:2'
    ];

    /**
     * Relation avec la chambre
     */
    public function chambre()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Calculer la durée du séjour en nuits
     */
    public function getDureeSejourAttribute()
    {
        return $this->date_checkin->diffInDays($this->date_checkout);
    }

    /**
     * Obtenir le nom complet du client
     */
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Vérifier si la réservation peut être annulée
     */
    public function peutEtreAnnulee()
    {
        return in_array($this->statut, ['en_attente', 'confirmee']) && 
               $this->date_checkin->isAfter(now()->addDay());
    }

    /**
     * Scopes pour filtrer les réservations
     */
    public function scopeConfirmees($query)
    {
        return $query->where('statut', 'confirmee');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeAnnulees($query)
    {
        return $query->where('statut', 'annulee');
    }

    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_checkin', today());
    }

    public function scopeProchaines($query)
    {
        return $query->where('date_checkin', '>=', today());
    }
}
