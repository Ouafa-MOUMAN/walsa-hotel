<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients avec pagination et filtres
     */
    public function index(Request $request)
    {
        $query = Client::query();

        // Recherche par nom, email ou téléphone
        if ($request->filled('search')) {
            $query->recherche($request->search);
        }

        // Filtre par statut
        if ($request->filled('status')) {
            if ($request->status === 'actif') {
                $query->actif();
            } elseif ($request->status === 'inactif') {
                $query->inactif();
            }
        }

        // SUPPRIMÉ: Les requêtes vers la table reservations
        // $query->withCount('reservations');
        // $query->addSelect([...]);

        $clients = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau client
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Enregistre un nouveau client
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'nationalite' => 'nullable|string|max:100',
            'piece_identite' => 'nullable|in:CNI,passeport,permis',
            'numero_piece' => 'nullable|string|max:50',
            'adresse' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'nullable|in:actif,inactif'
        ]);

        // Gestion de l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Définir le statut par défaut
        $validated['statut'] = $validated['statut'] ?? 'actif';

        Client::create($validated);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client créé avec succès');
    }

    /**
     * Affiche les détails d'un client (pour AJAX)
     */
    public function show(Client $client)
    {
        // SUPPRIMÉ: Chargement des réservations
        // $client->load('reservations');
        
        return response()->json($client);
    }

    /**
     * Affiche le formulaire de modification d'un client
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Met à jour un client existant
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'nationalite' => 'nullable|string|max:100',
            'piece_identite' => 'nullable|in:CNI,passeport,permis',
            'numero_piece' => 'nullable|string|max:50',
            'adresse' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'required|in:actif,inactif'
        ]);

        // Gestion de l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($client->avatar) {
                Storage::disk('public')->delete($client->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $client->update($validated);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client mis à jour avec succès');
    }

    /**
     * Supprime un client
     */
    public function destroy(Client $client)
    {
        // Supprimer l'avatar s'il existe
        if ($client->avatar) {
            Storage::disk('public')->delete($client->avatar);
        }

        // SUPPRIMÉ: Vérification des réservations actives
        // $reservationsActives = $client->reservations()...

        $client->delete();

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client supprimé avec succès');
    }

    /**
     * Exporte la liste des clients en CSV
     */
    public function export()
    {
        $clients = Client::all();
        
        $filename = 'clients_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($clients) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Prénom', 'Nom', 'Email', 'Téléphone', 
                'Date de naissance', 'Nationalité', 'Statut', 
                'Date de création'
            ]);

            // Données
            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->id,
                    $client->prenom,
                    $client->nom,
                    $client->email,
                    $client->telephone,
                    $client->date_naissance,
                    $client->nationalite,
                    $client->statut,
                    $client->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}