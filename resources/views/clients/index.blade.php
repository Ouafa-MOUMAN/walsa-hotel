@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="bi bi-people-fill text-primary"></i>
            Gestion des Clients - Hôtel
        </h3>
        <div class="badge bg-info fs-6">
            Total: {{ $clients->count() }} clients
        </div>
    </div>

    <!-- Alertes de succès/erreur -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Barre d'actions -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterClientModal">
                        <i class="bi bi-person-plus"></i> Nouveau Client
                    </button>
                </div>
                <div class="col-md-8">
                    <form method="GET" action="{{ route('admin.clients.index') }}" class="d-flex gap-2">
                        <div class="input-group flex-grow-1">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par nom, email, téléphone..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <select name="status" class="form-select" style="width: auto;" onchange="this.form.submit()">
                            <option value="">Tous les statuts</option>
                            <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actifs</option>
                            <option value="inactif" {{ request('status') == 'inactif' ? 'selected' : '' }}>Inactifs</option>
                        </select>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des clients -->
    <!-- Tableau des clients -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Liste des Clients</h5>
    </div>
    <div class="card-body p-0">
        @if($clients->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Informations Client</th>
                            <th class="text-center">Contact</th>
                            <th class="text-center">Statut</th>
                            <!-- SUPPRIMÉ: <th class="text-center">Réservations</th> -->
                            <th class="text-center">Membre depuis</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td class="text-center align-middle">
                                <span class="badge bg-secondary">#{{ $client->id }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        @if($client->avatar)
                                            <img src="{{ asset('storage/' . $client->avatar) }}" 
                                                 class="rounded-circle" width="50" height="50" alt="Avatar">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                                                {{ strtoupper(substr($client->prenom, 0, 1) . substr($client->nom, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $client->prenom }} {{ $client->nom }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-cake"></i> 
                                            {{ $client->date_naissance ? \Carbon\Carbon::parse($client->date_naissance)->format('d/m/Y') : 'Non renseigné' }}
                                            @if($client->date_naissance)
                                                ({{ \Carbon\Carbon::parse($client->date_naissance)->age }} ans)
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div>
                                    <i class="bi bi-envelope text-primary"></i>
                                    <small class="d-block">{{ $client->email }}</small>
                                </div>
                                @if($client->telephone)
                                    <div class="mt-1">
                                        <i class="bi bi-telephone text-success"></i>
                                        <small class="d-block">{{ $client->telephone }}</small>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($client->statut == 'actif')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Actif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-pause-circle"></i> Inactif
                                    </span>
                                @endif
                            </td>
                            <!-- SUPPRIMÉ: Colonne Réservations -->
                            <td class="text-center align-middle">
                                <small class="text-muted">
                                    {{ $client->created_at->format('d/m/Y') }}
                                </small>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-info" 
                                            title="Voir détails"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#voirClientModal"
                                            data-client-id="{{ $client->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" 
                                            title="Modifier"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modifierClientModal"
                                            data-client-id="{{ $client->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            title="Supprimer"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#supprimerClientModal"
                                            data-client-id="{{ $client->id }}"
                                            data-client-nom="{{ $client->prenom }} {{ $client->nom }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Aucun client trouvé</h5>
                <p class="text-muted">
                    @if(request('search'))
                        Aucun résultat pour "{{ request('search') }}"
                    @else
                        Commencez par ajouter votre premier client
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
    <!-- Pagination -->
    @if($clients->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Affichage de {{ $clients->firstItem() }} à {{ $clients->lastItem() }} 
                sur {{ $clients->total() }} résultats
            </div>
            {{ $clients->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Modal Ajouter Client -->
<div class="modal fade" id="ajouterClientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus"></i> Nouveau Client
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom *</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nationalite" class="form-label">Nationalité</label>
                            <input type="text" class="form-control" id="nationalite" name="nationalite">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="piece_identite" class="form-label">Pièce d'identité</label>
                            <select class="form-select" id="piece_identite" name="piece_identite">
                                <option value="">Sélectionner...</option>
                                <option value="CNI">Carte Nationale d'Identité</option>
                                <option value="passeport">Passeport</option>
                                <option value="permis">Permis de conduire</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="numero_piece" class="form-label">Numéro de pièce</label>
                            <input type="text" class="form-control" id="numero_piece" name="numero_piece">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse complète</label>
                        <textarea class="form-control" id="adresse" name="adresse" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Photo de profil</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modifier Client -->
<div class="modal fade" id="modifierClientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square"></i> Modifier Client
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editClientForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div id="editClientContent">
                        <!-- Contenu chargé dynamiquement -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-lg"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Voir Client -->
<div class="modal fade" id="voirClientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-eye"></i> Détails du Client
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="voirClientContent">
                    <!-- Contenu chargé dynamiquement -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer Client -->
<div class="modal fade" id="supprimerClientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i> Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Êtes-vous sûr ?</h5>
                    <p>Cette action supprimera définitivement le client <strong id="clientNomSupprimer"></strong> et toutes ses données associées.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i>
                        Cette action est irréversible !
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteClientForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Modifier Client
    const modifierModal = document.getElementById('modifierClientModal');
    if (modifierModal) {
        modifierModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const clientId = button.getAttribute('data-client-id');
            const form = document.getElementById('editClientForm');
            
            form.action = `{{ route('admin.clients.update', ':id') }}`.replace(':id', clientId);
            
            // Charger les données du client via AJAX
            fetch(`{{ route('admin.clients.show', ':id') }}`.replace(':id', clientId))
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editClientContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom *</label>
                                <input type="text" class="form-control" name="prenom" value="${data.prenom}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom *</label>
                                <input type="text" class="form-control" name="nom" value="${data.nom}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" value="${data.email}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" name="telephone" value="${data.telephone || ''}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" class="form-control" name="date_naissance" value="${data.date_naissance || ''}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Statut</label>
                                <select class="form-select" name="statut">
                                    <option value="actif" ${data.statut === 'actif' ? 'selected' : ''}>Actif</option>
                                    <option value="inactif" ${data.statut === 'inactif' ? 'selected' : ''}>Inactif</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea class="form-control" name="adresse" rows="3">${data.adresse || ''}</textarea>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('editClientContent').innerHTML = '<div class="alert alert-danger">Erreur lors du chargement des données</div>';
                });
        });
    }

    // Modal Voir Client
    const voirModal = document.getElementById('voirClientModal');
    if (voirModal) {
        voirModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const clientId = button.getAttribute('data-client-id');
            
            // Charger les détails du client via AJAX
            fetch(`{{ route('admin.clients.show', ':id') }}`.replace(':id', clientId))
                .then(response => response.json())
                .then(data => {
                    document.getElementById('voirClientContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 text-center">
                                ${data.avatar ? 
                                    `<img src="/storage/${data.avatar}" class="rounded-circle mb-3" width="120" height="120">` :
                                    `<div class="bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 2rem; font-weight: bold;">
                                        ${data.prenom.charAt(0)}${data.nom.charAt(0)}
                                    </div>`
                                }
                                <h5>${data.prenom} ${data.nom}</h5>
                                <span class="badge bg-${data.statut === 'actif' ? 'success' : 'secondary'}">${data.statut}</span>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr><td><strong>Email:</strong></td><td>${data.email}</td></tr>
                                    <tr><td><strong>Téléphone:</strong></td><td>${data.telephone || 'Non renseigné'}</td></tr>
                                    <tr><td><strong>Date de naissance:</strong></td><td>${data.date_naissance || 'Non renseigné'}</td></tr>
                                    <tr><td><strong>Nationalité:</strong></td><td>${data.nationalite || 'Non renseigné'}</td></tr>
                                    <tr><td><strong>Pièce d'identité:</strong></td><td>${data.piece_identite || 'Non renseigné'}</td></tr>
                                    <tr><td><strong>N° de pièce:</strong></td><td>${data.numero_piece || 'Non renseigné'}</td></tr>
                                    <tr><td><strong>Adresse:</strong></td><td>${data.adresse || 'Non renseigné'}</td></tr>
                                    <tr><td><strong>Membre depuis:</strong></td><td>${new Date(data.created_at).toLocaleDateString('fr-FR')}</td></tr>
                                </table>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('voirClientContent').innerHTML = '<div class="alert alert-danger">Erreur lors du chargement des données</div>';
                });
        });
    }

    // Modal Supprimer Client
    const supprimerModal = document.getElementById('supprimerClientModal');
    if (supprimerModal) {
        supprimerModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const clientId = button.getAttribute('data-client-id');
            const clientNom = button.getAttribute('data-client-nom');
            
            document.getElementById('clientNomSupprimer').textContent = clientNom;
            document.getElementById('deleteClientForm').action = `{{ route('admin.clients.destroy', ':id') }}`.replace(':id', clientId);
        });
    }
});
</script>
@endsection