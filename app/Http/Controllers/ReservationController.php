<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Afficher la liste des réservations
     */
    public function index(Request $request)
    {
        $query = Reservation::with('chambre')->latest();

        // Filtres
        if ($request->has('statut') && $request->statut !== '') {
            $query->where('statut', $request->statut);
        }

        if ($request->has('date_checkin') && $request->date_checkin !== '') {
            $query->whereDate('date_checkin', $request->date_checkin);
        }

        if ($request->has('recherche') && $request->recherche !== '') {
            $recherche = $request->recherche;
            $query->where(function($q) use ($recherche) {
                $q->where('nom', 'like', "%{$recherche}%")
                  ->orWhere('prenom', 'like', "%{$recherche}%")
                  ->orWhere('telephone', 'like', "%{$recherche}%")
                  ->orWhere('email', 'like', "%{$recherche}%");
            });
        }

        $reservations = $query->paginate(15);

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $chambres = Room::disponibles()->get();
        return view('admin.reservations.create', compact('chambres'));
    }

    /**
     * Enregistrer une nouvelle réservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'chambre_id' => 'required|exists:chambres,id',
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'date_checkin' => 'required|date|after_or_equal:today',
            'date_checkout' => 'required|date|after:date_checkin',
            'nombre_adultes' => 'required|integer|min:1|max:10',
            'nombre_enfants' => 'integer|min:0|max:10',
            'commentaires' => 'nullable|string|max:1000',
            'methode_paiement' => 'required|in:paypal,carte,especes'
        ]);

        $chambre = Room::findOrFail($request->chambre_id);
        
        // Vérifier la disponibilité
        if (!$chambre->estDisponible($request->date_checkin, $request->date_checkout)) {
            return back()->withErrors(['chambre_id' => 'Cette chambre n\'est pas disponible pour les dates sélectionnées.']);
        }

        // Calculer le prix total
        $dateCheckin = Carbon::parse($request->date_checkin);
        $dateCheckout = Carbon::parse($request->date_checkout);
        $nombreNuits = $dateCheckin->diffInDays($dateCheckout);
        $prixTotal = $nombreNuits * $chambre->prix_par_nuit;

        $reservation = Reservation::create([
            'chambre_id' => $request->chambre_id,
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'date_checkin' => $request->date_checkin,
            'date_checkout' => $request->date_checkout,
            'nombre_adultes' => $request->nombre_adultes,
            'nombre_enfants' => $request->nombre_enfants ?? 0,
            'prix_total' => $prixTotal,
            'commentaires' => $request->commentaires,
            'methode_paiement' => $request->methode_paiement,
            'statut' => 'confirmee'
        ]);

        return redirect()->route('admin.reservations.index')
                        ->with('success', 'Réservation créée avec succès!');
    }

    /**
     * Afficher les détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('chambre');
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Annuler une réservation
     */
    public function destroy(Reservation $reservation)
    {
        if (!$reservation->peutEtreAnnulee()) {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être annulée.']);
        }

        $reservation->update(['statut' => 'annulee']);

        return redirect()->route('admin.reservations.index')
                        ->with('success', 'Réservation annulée avec succès!');
    }

    /**
     * Confirmer une réservation en attente
     */
    public function confirmer(Reservation $reservation)
    {
        if ($reservation->statut !== 'en_attente') {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être confirmée.']);
        }

        $reservation->update(['statut' => 'confirmee']);

        return back()->with('success', 'Réservation confirmée avec succès!');
    }

    /**
     * Marquer une réservation comme terminée (check-out)
     */
    public function checkout(Reservation $reservation)
    {
        if ($reservation->statut !== 'confirmee') {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être terminée.']);
        }

        $reservation->update(['statut' => 'terminee']);

        return back()->with('success', 'Check-out effectué avec succès!');
    }
}
