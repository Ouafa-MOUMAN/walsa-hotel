@extends('layouts.app')

@section('title', 'Réservation - Walsa Hotel')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .room-info-card {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            border-radius: 15px;
            color: white;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group label {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #6b7280;
            font-size: 14px;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label,
        .input-group select:focus + label,
        .input-group select:not([value=""]) + label {
            top: -8px;
            left: 8px;
            font-size: 12px;
            background: white;
            padding: 0 4px;
            color: #10B981;
        }
        
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #10B981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }
        
        .price-calculator {
            background: #f8fafc;
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #10B981;
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
    </style>
</head>
<body>
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Réservation</h1>
                <p class="text-white opacity-90">Finalisez votre réservation</p>
            </div>

            <!-- Affichage des messages d'erreur -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-container p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Informations de la chambre -->
                    <div class="room-info-card p-6">
                        <h2 class="text-2xl font-bold mb-4">Détails de la chambre</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span>Nom de la chambre:</span>
                                <span id="roomName" class="font-semibold">{{ $room->room_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Type:</span>
                                <span id="roomType" class="font-semibold">{{ $room->room_type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Capacité:</span>
                                <span id="roomCapacity" class="font-semibold">{{ $room->capacity }} personne{{ $room->capacity > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Étage:</span>
                                <span id="roomFloor" class="font-semibold">{{ $room->room_floor }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Prix par nuit:</span>
                                <span id="pricePerNight" class="font-semibold">{{ number_format($room->price_per_night, 0) }} $</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Équipements:</span>
                                <span id="roomAmenities" class="font-semibold">
                                    @if($room->amenities)
                                        {{ str_replace(',', ', ', $room->amenities) }}
                                    @else
                                        Aucun équipement spécifié
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de réservation -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Vos informations</h2>
                        <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="input-group">
                                    <input type="text" id="firstName" name="first_name" placeholder=" " 
                                           value="{{ old('first_name', Auth::user()->first_name ?? '') }}" required>
                                    <label for="firstName">Prénom</label>
                                    @error('first_name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <input type="text" id="lastName" name="last_name" placeholder=" " 
                                           value="{{ old('last_name', Auth::user()->last_name ?? '') }}" required>
                                    <label for="lastName">Nom</label>
                                    @error('last_name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="tel" id="phone" name="phone" placeholder=" " 
                                       value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                                <label for="phone">Téléphone</label>
                                @error('phone')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group">
                                <input type="email" id="email" name="email" placeholder=" " 
                                       value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-group">
                                <input type="text" id="address" name="address" placeholder=" " 
                                       value="{{ old('address', Auth::user()->address ?? '') }}" required>
                                <label for="address">Adresse complète</label>
                                @error('address')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="input-group">
                                    <input type="date" id="checkIn" name="check_in" placeholder=" " 
                                           value="{{ old('check_in') }}" required>
                                    <label for="checkIn">Date d'arrivée</label>
                                    @error('check_in')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <input type="date" id="checkOut" name="check_out" placeholder=" " 
                                           value="{{ old('check_out') }}" required>
                                    <label for="checkOut">Date de départ</label>
                                    @error('check_out')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group">
                                <select id="nights" name="nights" required>
                                    <option value="">Choisir le nombre de nuits</option>
                                    @for($i = 1; $i <= 30; $i++)
                                        <option value="{{ $i }}" {{ old('nights') == $i ? 'selected' : '' }}>
                                            {{ $i }} nuit{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                                <label for="nights">Nombre de nuits</label>
                                @error('nights')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Calculateur de prix -->
                            <div class="price-calculator">
                                <h3 class="text-lg font-semibold mb-3 text-gray-800">Récapitulatif des coûts</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>Prix par nuit:</span>
                                        <span id="displayPricePerNight">{{ number_format($room->price_per_night, 0) }} $</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Nombre de nuits:</span>
                                        <span id="displayNights">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Sous-total:</span>
                                        <span id="subtotal">0 $</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Taxes (10%):</span>
                                        <span id="taxes">0 $</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span id="totalPrice" class="total-price">0 $</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="flex space-x-4 pt-6">
                                <button type="button" id="cancelBtn" class="btn-secondary flex-1">
                                    Annuler
                                </button>
                                <button type="submit" class="btn-primary flex-1">
                                    Confirmer la réservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4">
            <div class="text-center">
                <div class="text-green-500 text-6xl mb-4">✓</div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Réservation confirmée !</h3>
                <p class="text-gray-600 mb-6">Votre réservation a été enregistrée avec succès. Vous recevrez un email de confirmation.</p>
                <button id="closeModal" class="btn-primary">Fermer</button>
            </div>
        </div>
    </div>

    <script>
        // Données de la chambre passées depuis Laravel
        const roomData = {
            id: {{ $room->id }},
            room_name: "{{ $room->room_name }}",
            room_type: "{{ $room->room_type }}",
            capacity: {{ $room->capacity }},
            room_floor: "{{ $room->room_floor }}",
            price_per_night: {{ $room->price_per_night }},
            amenities: "{{ $room->amenities }}"
        };

        // Fonction pour calculer le prix total
        function calculatePrice() {
            const nights = parseInt(document.getElementById('nights').value) || 0;
            const pricePerNight = roomData.price_per_night;
            
            const subtotal = nights * pricePerNight;
            const taxes = subtotal * 0.1; // 10% de taxes
            const total = subtotal + taxes;
            
            document.getElementById('displayNights').textContent = nights;
            document.getElementById('subtotal').textContent = `${subtotal} $`;
            document.getElementById('taxes').textContent = `${taxes.toFixed(2)} $`;
            document.getElementById('totalPrice').textContent = `${total.toFixed(2)} $`;
        }

        // Fonction pour calculer automatiquement les nuits basées sur les dates
        function calculateNightsByDates() {
            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;
            
            if (checkIn && checkOut) {
                const startDate = new Date(checkIn);
                const endDate = new Date(checkOut);
                
                if (endDate > startDate) {
                    const timeDiff = endDate.getTime() - startDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    
                    document.getElementById('nights').value = nights;
                    calculatePrice();
                }
            }
        }

        // Fonction de validation du formulaire côté client
        function validateForm() {
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const address = document.getElementById('address').value.trim();
            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;
            const nights = document.getElementById('nights').value;

            if (!firstName || !lastName || !phone || !email || !address || !checkIn || !checkOut || !nights) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return false;
            }

            // Validation email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Veuillez entrer un email valide.');
                return false;
            }

            // Validation téléphone
            const phoneRegex = /^[0-9+\-\s()]+$/;
            if (!phoneRegex.test(phone)) {
                alert('Veuillez entrer un numéro de téléphone valide.');
                return false;
            }

            // Validation des dates
            const today = new Date();
            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);

            if (checkInDate < today) {
                alert('La date d\'arrivée ne peut pas être antérieure à aujourd\'hui.');
                return false;
            }

            if (checkOutDate <= checkInDate) {
                alert('La date de départ doit être postérieure à la date d\'arrivée.');
                return false;
            }

            return true;
        }

        // Événements
        document.addEventListener('DOMContentLoaded', function() {
            // Définir la date minimale pour les champs de date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('checkIn').min = today;
            document.getElementById('checkOut').min = today;

            // Événements pour le calcul du prix
            document.getElementById('nights').addEventListener('change', calculatePrice);
            document.getElementById('checkIn').addEventListener('change', calculateNightsByDates);
            document.getElementById('checkOut').addEventListener('change', calculateNightsByDates);

            // Calculer le prix initial si des valeurs sont déjà présentes
            calculatePrice();

            // Validation avant soumission
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });

            // Bouton d'annulation
            document.getElementById('cancelBtn').addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                    window.location.href = "{{ route('home') }}";
                }
            });

            // Fermer le modal de confirmation
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden');
                window.location.href = "{{ route('home') }}";
            });
        });
    </script>
</body>
</html>
@endsection