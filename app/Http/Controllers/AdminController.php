<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function isMainAdmin()
    {
        return request()->session()->get('is_admin') === true;
    }

    /**
     * Afficher le tableau de bord admin
     */
    public function dashboard()
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Données exemple pour le dashboard
        $stats = [
            'chambres_disponibles' => 24,
            'reservations_aujourdhui' => 12,
            'clients_presents' => 48,
            'revenus_jour' => 3250
        ];

        $reservations_recentes = [
            [
                'client' => 'Marie Dubois',
                'chambre' => 'Suite 201',
                'checkin' => 'Aujourd\'hui',
                'checkout' => '15/06/2025',
                'statut' => 'Confirmée',
                'statut_class' => 'success'
            ],
            [
                'client' => 'Jean Martin',
                'chambre' => 'Chambre 105',
                'checkin' => '05/06/2025',
                'checkout' => 'Aujourd\'hui',
                'statut' => 'Check-out',
                'statut_class' => 'warning'
            ],
            [
                'client' => 'Sophie Bernard',
                'chambre' => 'Chambre 302',
                'checkin' => 'Demain',
                'checkout' => '10/06/2025',
                'statut' => 'En attente',
                'statut_class' => 'info'
            ]
        ];

        return view('admin.dashboard', compact('stats', 'reservations_recentes'));
    }

    /**
     * Afficher la liste des admins
     */
    public function index()
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Afficher la gestion des chambres
     */
    public function chambres()
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Données exemple pour les chambres
        $chambres = [
            ['numero' => '101', 'type' => 'Standard', 'statut' => 'Disponible', 'prix' => 120],
            ['numero' => '201', 'type' => 'Suite', 'statut' => 'Occupée', 'prix' => 280],
            ['numero' => '105', 'type' => 'Standard', 'statut' => 'Maintenance', 'prix' => 120],
        ];

        return view('admin.chambres.index', compact('chambres'));
    }

    /**
     * Afficher la gestion des réservations
     */
    public function reservations()
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Données exemple pour les réservations
        $reservations = [
            [
                'id' => 1,
                'client' => 'Marie Dubois',
                'chambre' => 'Suite 201',
                'checkin' => '2025-06-04',
                'checkout' => '2025-06-15',
                'statut' => 'Confirmée',
                'total' => 2800
            ],
            [
                'id' => 2,
                'client' => 'Jean Martin',
                'chambre' => 'Chambre 105',
                'checkin' => '2025-06-05',
                'checkout' => '2025-06-04',
                'statut' => 'Check-out',
                'total' => 1200
            ]
        ];

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Afficher la gestion des clients
     */
    public function clients()
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        // Données exemple pour les clients
        $clients = [
            ['nom' => 'Dubois', 'prenom' => 'Marie', 'email' => 'marie.dubois@email.com', 'telephone' => '0123456789'],
            ['nom' => 'Martin', 'prenom' => 'Jean', 'email' => 'jean.martin@email.com', 'telephone' => '0987654321'],
        ];

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Créer un admin
     */
    public function store(Request $request)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin créé avec succès');
    }

    /**
     * Modifier un admin existant
     */
    public function update(Request $request, $id)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }
        
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:admins,email,{$id}",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.admins.index')->with('success', 'Admin modifié avec succès');
    }

    /**
     * Supprimer un admin
     */
    public function destroy($id)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $admin = Admin::findOrFail($id);

        // Empêcher la suppression de l'admin principal
        if ($admin->email === 'walsa.admin@gmail.com') {
            return redirect()->route('admin.admins.index')->with('error', 'Impossible de supprimer l\'administrateur principal.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin supprimé avec succès');
    }
}