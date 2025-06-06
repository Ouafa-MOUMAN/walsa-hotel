<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom', 
        'email',
        'telephone',
        'date_naissance',
        'nationalite',
        'piece_identite',
        'numero_piece',
        'adresse',
        'avatar',
        'statut',
        'mot_de_passe',
        'sexe'
    ];

    protected $dates = [
        'date_naissance',
        'created_at',
        'updated_at'
    ];

    /**
     * Relation avec les réservations (si vous avez une table reservations)
     */
    

    /**
     * Accesseur pour obtenir le nom complet
     */
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Accesseur pour obtenir l'âge
     */
    public function getAgeAttribute()
    {
        if (!$this->date_naissance) {
            return null;
        }
        return \Carbon\Carbon::parse($this->date_naissance)->age;
    }

    /**
     * Scope pour filtrer les clients actifs
     */
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour filtrer les clients inactifs
     */
    public function scopeInactif($query)
    {
        return $query->where('statut', 'inactif');
    }

    /**
     * Scope pour rechercher par nom, email ou téléphone
     */
    public function scopeRecherche($query, $terme)
    {
        return $query->where(function($q) use ($terme) {
            $q->where('prenom', 'LIKE', "%{$terme}%")
              ->orWhere('nom', 'LIKE', "%{$terme}%")
              ->orWhere('email', 'LIKE', "%{$terme}%")
              ->orWhere('telephone', 'LIKE', "%{$terme}%");
        });
    }
}