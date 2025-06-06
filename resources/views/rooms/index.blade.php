@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-5">
    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3 class="mb-4">Gestion des chambres</h3>

    <div class="d-flex justify-content-between mb-3">
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ajouterChambreModal">
            <i class="bi bi-plus-circle me-2"></i>Ajouter une chambre
        </button>
        
        <!-- Barre de recherche (optionnelle) -->
        <div class="d-flex align-items-center">
            <input type="text" class="form-control me-2" placeholder="Rechercher..." style="width: 250px;">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-warning">
                <tr>
                    <th>Image</th>
                    <th>Nom de la chambre</th>
                    <th>Type de chambre</th>
                    <th>Étage</th>
                    <th>Statut</th>
                    <th>Prix/Nuit (€)</th>
                    <th>Capacité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr class="{{ $loop->even ? 'table-light' : '' }}" style="{{ $loop->odd ? 'background-color: #d1ecf1;' : '' }}">
                    <td class="align-middle">
                        @if($room->image)
                            <img src="{{ Storage::url($room->image) }}" alt="{{ $room->room_name }}" 
                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 60px; border-radius: 8px; border: 1px solid #dee2e6;">
                                <i class="bi bi-image text-muted" style="font-size: 1.5rem;"></i>
                            </div>
                        @endif
                    </td>
                    <td class="align-middle">
                        <strong>{{ $room->room_name }}</strong>
                    </td>
                    <td class="align-middle">{{ $room->room_type }}</td>
                    <td class="align-middle">{{ $room->room_floor }}</td>
                    <td class="align-middle">
                        <span class="badge {{ $room->getStatusBadgeClass() }}">
                            {{ $room->status }}
                        </span>
                    </td>
                    <td class="align-middle">{{ number_format($room->price_per_night, 2) }}</td>
                    <td class="align-middle">{{ $room->capacity }} pers.</td>
                    <td class="align-middle">
                        <button class="btn btn-sm btn-info me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modifierChambreModal"
                                data-id="{{ $room->id }}"
                                data-room_name="{{ $room->room_name }}"
                                data-room_type="{{ $room->room_type }}"
                                data-room_floor="{{ $room->room_floor }}"
                                data-status="{{ $room->status }}"
                                data-price_per_night="{{ $room->price_per_night }}"
                                data-capacity="{{ $room->capacity }}"
                                data-amenities="{{ $room->amenities }}"
                                data-image="{{ $room->image }}">
                            <i class="bi bi-pencil-square text-white"></i>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#supprimerChambreModal"
                                data-id="{{ $room->id }}"
                                data-room_name="{{ $room->room_name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-3"></i>
                            Aucune chambre trouvée
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center">
        <div>Affichage de {{ $rooms->count() }} chambres</div>
        <!-- Vous pouvez ajouter une pagination ici si nécessaire -->
    </div>
</div>

<!-- Modal Ajouter Chambre -->
<div class="modal fade" id="ajouterChambreModal" tabindex="-1" aria-labelledby="ajouterChambreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="ajouterChambreModalLabel">Ajouter une chambre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="room_name" class="form-label">Nom de la chambre*</label>
                            <input type="text" class="form-control" id="room_name" name="room_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="room_type" class="form-label">Type de chambre*</label>
                            <select class="form-control" id="room_type" name="room_type" required>
                                <option value="">Sélectionner un type</option>
                                @foreach(\App\Models\Room::ROOM_TYPES as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="room_floor" class="form-label">Étage*</label>
                            <input type="text" class="form-control" id="room_floor" name="room_floor" required 
                                   placeholder="ex: Floor G05">
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Statut*</label>
                            <select class="form-control" id="status" name="status" required>
                                @foreach(\App\Models\Room::getStatuses() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price_per_night" class="form-label">Prix par nuit (€)*</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="price_per_night" name="price_per_night" required>
                        </div>
                        <div class="col-md-6">
                            <label for="capacity" class="form-label">Capacité (personnes)*</label>
                            <input type="number" min="1" class="form-control" id="capacity" name="capacity" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image de la chambre</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Formats acceptés: JPG, PNG, GIF (max: 2MB)</div>
                        <!-- Prévisualisation de l'image sélectionnée -->
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Aperçu" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="amenities" class="form-label">Équipements</label>
                        <textarea class="form-control" id="amenities" name="amenities" rows="3" 
                                  placeholder="ex: WiFi gratuit, Climatisation, TV LCD, Mini-bar..."></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifier Chambre -->
<div class="modal fade" id="modifierChambreModal" tabindex="-1" aria-labelledby="modifierChambreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="modifierChambreModalLabel">Modifier une chambre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.rooms.update', '__ID__') }}" method="POST" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_room_name" class="form-label">Nom de la chambre*</label>
                            <input type="text" class="form-control" id="edit_room_name" name="room_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_room_type" class="form-label">Type de chambre*</label>
                            <select class="form-control" id="edit_room_type" name="room_type" required>
                                <option value="">Sélectionner un type</option>
                                @foreach(\App\Models\Room::ROOM_TYPES as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_room_floor" class="form-label">Étage*</label>
                            <input type="text" class="form-control" id="edit_room_floor" name="room_floor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_status" class="form-label">Statut*</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                @foreach(\App\Models\Room::getStatuses() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_price_per_night" class="form-label">Prix par nuit (€)*</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="edit_price_per_night" name="price_per_night" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_capacity" class="form-label">Capacité (personnes)*</label>
                            <input type="number" min="1" class="form-control" id="edit_capacity" name="capacity" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Image de la chambre</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div class="form-text">Laisser vide pour conserver l'image actuelle</div>
                        <div id="current_image_preview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_amenities" class="form-label">Équipements</label>
                        <textarea class="form-control" id="edit_amenities" name="amenities" rows="3"></textarea>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-info text-white">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer Chambre -->
<div class="modal fade" id="supprimerChambreModal" tabindex="-1" aria-labelledby="supprimerChambreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="supprimerChambreModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette chambre ? Cette action est irréversible.</p>
                <p id="chambreInfo"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.rooms.destroy', '__ID__') }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prévisualisation de l'image lors de l'ajout
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
        }

        // Modal de modification
        const editModal = document.getElementById('modifierChambreModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const form = document.getElementById('editForm');

                document.getElementById('edit_room_name').value = button.dataset.room_name;
                document.getElementById('edit_room_type').value = button.dataset.room_type;
                document.getElementById('edit_room_floor').value = button.dataset.room_floor;
                document.getElementById('edit_status').value = button.dataset.status;
                document.getElementById('edit_price_per_night').value = button.dataset.price_per_night;
                document.getElementById('edit_capacity').value = button.dataset.capacity;
                document.getElementById('edit_amenities').value = button.dataset.amenities;

                // Afficher l'image actuelle
                const imagePreview = document.getElementById('current_image_preview');
                if (button.dataset.image) {
                    imagePreview.innerHTML = `
                        <div class="current-image">
                            <small class="text-muted">Image actuelle:</small><br>
                            <img src="/storage/${button.dataset.image}" alt="Image actuelle" class="img-thumbnail mt-1" style="max-width: 150px;">
                        </div>
                    `;
                } else {
                    imagePreview.innerHTML = '<small class="text-muted">Aucune image actuelle</small>';
                }

                form.action = `/admin/rooms/${button.dataset.id}`;
            });
        }

        // Modal de suppression
        const deleteModal = document.getElementById('supprimerChambreModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const form = document.getElementById('deleteForm');

                document.getElementById('chambreInfo').innerHTML =
                    `Chambre: <strong>${button.dataset.room_name}</strong>`;

                form.action = `/admin/rooms/${button.dataset.id}`;
            });
        }
    });
</script>
@endsection