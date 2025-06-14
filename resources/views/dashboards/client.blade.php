<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=USD"></script>
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
        
        .payment-section {
            background: #f8fafc;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
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
        
        .payment-method {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }
        
        .payment-method:hover {
            border-color: #10B981;
        }
        
        .payment-method.selected {
            border-color: #10B981;
            background-color: rgba(16, 185, 129, 0.05);
        }
        
        .payment-method input[type="radio"] {
            margin-right: 10px;
        }
        
        #paypal-button-container {
            margin-top: 20px;
            min-height: 45px;
        }
        
        .hidden {
            display: none !important;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #10B981;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

            <div class="form-container p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Informations de la chambre -->
                    <div class="room-info-card p-6">
                        <h2 class="text-2xl font-bold mb-4">Détails de la chambre</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span>Nom de la chambre:</span>
                                <span id="roomName" class="font-semibold">Comfort S-102</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Type:</span>
                                <span id="roomType" class="font-semibold">Single rooms</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Capacité:</span>
                                <span id="roomCapacity" class="font-semibold">1 personne</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Étage:</span>
                                <span id="roomFloor" class="font-semibold">Floor C01</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Prix par nuit:</span>
                                <span id="pricePerNight" class="font-semibold">110 $</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Équipements:</span>
                                <span id="roomAmenities" class="font-semibold">WiFi, TV, Climatisation</span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de réservation -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Vos informations</h2>
                        <form id="bookingForm" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="input-group">
                                    <input type="text" id="firstName" name="firstName" placeholder=" " required>
                                    <label for="firstName">Prénom</label>
                                </div>
                                <div class="input-group">
                                    <input type="text" id="lastName" name="lastName" placeholder=" " required>
                                    <label for="lastName">Nom</label>
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="tel" id="phone" name="phone" placeholder=" " required>
                                <label for="phone">Téléphone</label>
                            </div>

                            <div class="input-group">
                                <input type="email" id="email" name="email" placeholder=" " required>
                                <label for="email">Email</label>
                            </div>

                            <div class="input-group">
                                <input type="text" id="address" name="address" placeholder=" " required>
                                <label for="address">Adresse complète</label>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="input-group">
                                    <input type="date" id="checkIn" name="checkIn" placeholder=" " required>
                                    <label for="checkIn">Date d'arrivée</label>
                                </div>
                                <div class="input-group">
                                    <input type="date" id="checkOut" name="checkOut" placeholder=" " required>
                                    <label for="checkOut">Date de départ</label>
                                </div>
                            </div>

                            <div class="input-group">
                                <select id="nights" name="nights" required>
                                    <option value="">Choisir le nombre de nuits</option>
                                    <option value="1">1 nuit</option>
                                    <option value="2">2 nuits</option>
                                    <option value="3">3 nuits</option>
                                    <option value="4">4 nuits</option>
                                    <option value="5">5 nuits</option>
                                    <option value="6">6 nuits</option>
                                    <option value="7">7 nuits</option>
                                    <option value="14">14 nuits</option>
                                    <option value="30">30 nuits</option>
                                </select>
                                <label for="nights">Nombre de nuits</label>
                            </div>

                            <!-- Calculateur de prix -->
                            <div class="price-calculator">
                                <h3 class="text-lg font-semibold mb-3 text-gray-800">Récapitulatif des coûts</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>Prix par nuit:</span>
                                        <span id="displayPricePerNight">110 $</span>
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

                            <!-- Section de paiement -->
                            <div class="payment-section">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800">Mode de paiement</h3>
                                
                                <div class="space-y-3">
                                    <div class="payment-method" data-method="paypal">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="paymentMethod" value="paypal" required>
                                            <span class="ml-2 flex items-center">
                                                <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" alt="PayPal" class="h-6 mr-2">
                                                PayPal
                                            </span>
                                        </label>
                                    </div>
                                    
                                    <div class="payment-method" data-method="card">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="paymentMethod" value="card">
                                            <span class="ml-2">💳 Carte de crédit/débit</span>
                                        </label>
                                    </div>
                                    
                                    <div class="payment-method" data-method="onsite">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="paymentMethod" value="onsite">
                                            <span class="ml-2">🏨 Paiement sur place</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Container pour les formulaires de paiement -->
                                <div id="paymentForms" class="mt-4">
                                    <!-- PayPal Container -->
                                    <div id="paypal-section" class="hidden">
                                        <div id="paypal-button-container"></div>
                                        <div id="paypal-loading" class="text-center hidden">
                                            <div class="loading"></div>
                                            <span class="ml-2">Chargement de PayPal...</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Formulaire carte de crédit -->
                                    <div id="card-section" class="hidden">
                                        <div class="grid md:grid-cols-2 gap-4 mt-4">
                                            <div class="input-group md:col-span-2">
                                                <input type="text" id="cardNumber" name="cardNumber" placeholder=" " maxlength="19">
                                                <label for="cardNumber">Numéro de carte</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" id="cardExpiry" name="cardExpiry" placeholder=" " maxlength="5">
                                                <label for="cardExpiry">MM/AA</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" id="cardCvc" name="cardCvc" placeholder=" " maxlength="4">
                                                <label for="cardCvc">CVC</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Message pour paiement sur place -->
                                    <div id="onsite-section" class="hidden">
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                                            <p class="text-blue-800">
                                                <strong>📍 Paiement sur place</strong><br>
                                                Vous pourrez régler votre séjour directement à l'hôtel lors de votre arrivée. 
                                                Nous acceptons les cartes de crédit, espèces et chèques.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="flex space-x-4 pt-6">
                                <button type="button" id="cancelBtn" class="btn-secondary flex-1">
                                    Annuler
                                </button>
                                <button type="submit" id="submitBtn" class="btn-primary flex-1">
                                    <span id="submitText">Confirmer la réservation</span>
                                    <div id="submitLoading" class="hidden">
                                        <div class="loading"></div>
                                    </div>
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
                <div id="paymentInfo" class="bg-gray-50 p-4 rounded-lg mb-4 hidden">
                    <p class="text-sm text-gray-600">
                        <strong>Transaction ID:</strong> <span id="transactionId"></span>
                    </p>
                </div>
                <button id="closeModal" class="btn-primary">Fermer</button>
            </div>
        </div>
    </div>

    <script>
        // Données de la chambre (normalement passées depuis Laravel)
        let roomData = {
            room_name: "Comfort S-102",
            room_type: "Single rooms",
            capacity: 1,
            room_floor: "Floor C01",
            price_per_night: 110,
            amenities: "wifi,tv,climatisation"
        };

        let currentTotal = 0;
        let paypalInitialized = false;

        // Fonction pour récupérer les paramètres URL
        function getUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const roomId = urlParams.get('room_id');
            return roomId;
        }

        // Fonction pour pré-remplir les informations de la chambre
        function populateRoomInfo() {
            document.getElementById('roomName').textContent = roomData.room_name;
            document.getElementById('roomType').textContent = roomData.room_type;
            document.getElementById('roomCapacity').textContent = `${roomData.capacity} personne${roomData.capacity > 1 ? 's' : ''}`;
            document.getElementById('roomFloor').textContent = roomData.room_floor;
            document.getElementById('pricePerNight').textContent = `${roomData.price_per_night} $`;
            document.getElementById('displayPricePerNight').textContent = `${roomData.price_per_night} $`;
            
            const amenities = roomData.amenities ? roomData.amenities.split(',').join(', ') : 'Aucun équipement spécifié';
            document.getElementById('roomAmenities').textContent = amenities;
        }

        // Fonction pour calculer le prix total
        function calculatePrice() {
            const nights = parseInt(document.getElementById('nights').value) || 0;
            const pricePerNight = roomData.price_per_night;
            
            const subtotal = nights * pricePerNight;
            const taxes = subtotal * 0.1;
            const total = subtotal + taxes;
            
            currentTotal = total;
            
            document.getElementById('displayNights').textContent = nights;
            document.getElementById('subtotal').textContent = `${subtotal} $`;
            document.getElementById('taxes').textContent = `${taxes.toFixed(2)} $`;
            document.getElementById('totalPrice').textContent = `${total.toFixed(2)} $`;
            
            // Réinitialiser PayPal si le prix change
            if (paypalInitialized) {
                initializePayPal();
            }
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

        // Initialiser PayPal
        function initializePayPal() {
            if (currentTotal <= 0) return;

            document.getElementById('paypal-button-container').innerHTML = '';
            
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: currentTotal.toFixed(2),
                                currency_code: 'USD'
                            },
                            description: `Réservation ${roomData.room_name} - ${document.getElementById('displayNights').textContent} nuit(s)`
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        // Paiement réussi
                        handlePaymentSuccess({
                            method: 'paypal',
                            transactionId: details.id,
                            payerName: details.payer.name.given_name + ' ' + details.payer.name.surname,
                            amount: currentTotal
                        });
                    });
                },
                onError: function(err) {
                    console.error('Erreur PayPal:', err);
                    alert('Une erreur est survenue lors du paiement PayPal. Veuillez réessayer.');
                },
                onCancel: function(data) {
                    console.log('Paiement PayPal annulé');
                }
            }).render('#paypal-button-container');
            
            paypalInitialized = true;
        }

        // Gérer le succès du paiement
        function handlePaymentSuccess(paymentData) {
            console.log('Paiement réussi:', paymentData);
            
            // Préparer les données de réservation
            const formData = new FormData(document.getElementById('bookingForm'));
            const bookingData = Object.fromEntries(formData);
            bookingData.room_id = roomData.id;
            bookingData.room_name = roomData.room_name;
            bookingData.total_price = currentTotal;
            bookingData.payment_method = paymentData.method;
            bookingData.transaction_id = paymentData.transactionId;
            bookingData.payment_status = 'completed';
            
            // Afficher les informations de transaction
            document.getElementById('transactionId').textContent = paymentData.transactionId;
            document.getElementById('paymentInfo').classList.remove('hidden');
            
            submitBooking(bookingData);
        }

        // Gestion des méthodes de paiement
        function handlePaymentMethodChange() {
            const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
            
            // Cacher toutes les sections
            document.getElementById('paypal-section').classList.add('hidden');
            document.getElementById('card-section').classList.add('hidden');
            document.getElementById('onsite-section').classList.add('hidden');
            
            // Retirer la classe selected de tous les conteneurs
            document.querySelectorAll('.payment-method').forEach(method => {
                method.classList.remove('selected');
            });
            
            if (selectedMethod) {
                const methodValue = selectedMethod.value;
                const methodContainer = selectedMethod.closest('.payment-method');
                methodContainer.classList.add('selected');
                
                // Afficher la section correspondante
                switch(methodValue) {
                    case 'paypal':
                        document.getElementById('paypal-section').classList.remove('hidden');
                        if (currentTotal > 0) {
                            initializePayPal();
                        }
                        break;
                    case 'card':
                        document.getElementById('card-section').classList.remove('hidden');
                        break;
                    case 'onsite':
                        document.getElementById('onsite-section').classList.remove('hidden');
                        break;
                }
            }
        }

        // Formatage des champs de carte
        function formatCardNumber(input) {
            let value = input.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let matches = value.match(/\d{4,16}/g);
            let match = matches && matches[0] || '';
            let parts = [];
            
            for (let i = 0, len = match.length; i < len; i += 4) {
                parts.push(match.substring(i, i + 4));
            }
            
            if (parts.length) {
                input.value = parts.join(' ');
            } else {
                input.value = value;
            }
        }

        function formatCardExpiry(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            input.value = value;
        }

        // Fonction de validation du formulaire
        function validateForm() {
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const address = document.getElementById('address').value.trim();
            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;
            const nights = document.getElementById('nights').value;
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');

            if (!firstName || !lastName || !phone || !email || !address || !checkIn || !checkOut || !nights) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return false;
            }

            if (!paymentMethod) {
                alert('Veuillez sélectionner un mode de paiement.');
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

            // Validation spécifique pour carte de crédit
            if (paymentMethod.value === 'card') {
                const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
                const cardExpiry = document.getElementById('cardExpiry').value;
                const cardCvc = document.getElementById('cardCvc').value;

                if (!cardNumber || cardNumber.length < 13 || cardNumber.length > 19) {
                    alert('Veuillez entrer un numéro de carte valide.');
                    return false;
                }

                if (!cardExpiry || cardExpiry.length !== 5) {
                    alert('Veuillez entrer une date d\'expiration valide (MM/AA).');
                    return false;
                }

                if (!cardCvc || cardCvc.length < 3 || cardCvc.length > 4) {
                    alert('Veuillez entrer un code CVC valide.');
                    return false;
                }
            }

            return true;
        }

        // Fonction pour soumettre la réservation
        function submitBooking(formData) {
            console.log('Données de réservation:', formData);
            
            // Dans un vrai projet Laravel, vous enverriez les données à votre contrôleur
            // Ici nous simulons l'envoi
            setTimeout(() => {
                document.getElementById('confirmationModal').classList.remove('hidden');
            }, 1000);
        }

        // Gestion de la soumission du formulaire
        function handleFormSubmit(e) {
            e.preventDefault();
            
            if (validateForm()) {
                const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
                
                if (paymentMethod === 'paypal') {
                    alert('Veuillez utiliser le bouton PayPal pour finaliser votre paiement.');
                    return;
                }
                
                // Afficher le loading
                document.getElementById('submitText').classList.add('hidden');
                document.getElementById('submitLoading').classList.remove('hidden');
                document.getElementById('submitBtn').disabled = true;
                
                // Préparer les données
                const formData = new FormData(e.target);
                const bookingData = Object.fromEntries(formData);
                bookingData.room_id = roomData.id;
                bookingData.room_name = roomData.room_name;
                bookingData.total_price = currentTotal;
                bookingData.payment_status = paymentMethod === 'onsite' ? 'pending' : 'processing';
                
                // Simuler le traitement
                setTimeout(() => {
                    document.getElementById('submitText').classList.remove('hidden');
                    document.getElementById('submitLoading').classList.add('hidden');
                    document.getElementById('submitBtn').disabled = false;
                    
                    if (paymentMethod === 'card') {
                        // Simuler le traitement de carte
                        bookingData.transaction_id = 'CARD_' + Date.now();
                        bookingData.payment_status = 'completed';
                    }
                    
                    submitBooking(bookingData);
                }, 2000);
            }
        }

        // Événements
        document.addEventListener('DOMContentLoaded', function() {
            // Pré-remplir les informations de la chambre
            populateRoomInfo();
            
            // Définir la date minimale pour les champs de date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('checkIn').min = today;
            document.getElementById('checkOut').min = today;

            // Événements pour le calcul du prix
            document.getElementById('nights').addEventListener('change', calculatePrice);
            document.getElementById('checkIn').addEventListener('change', calculateNightsByDates);
            document.getElementById('checkOut').addEventListener('change', calculateNightsByDates);

            // Événements pour les méthodes de paiement
            document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
                radio.addEventListener('change', handlePaymentMethodChange);
            });

            // Événements pour le formatage des cartes
            document.getElementById('cardNumber').addEventListener('input', function(e) {
                formatCardNumber(e.target);
            });

            document.getElementById('cardExpiry').addEventListener('input', function(e) {
                formatCardExpiry(e.target);
            });

            document.getElementById('cardCvc').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            // Soumission du formulaire
            document.getElementById('bookingForm').addEventListener('submit', handleFormSubmit);

            // Bouton d'annulation
            document.getElementById('cancelBtn').addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                    window.location.href = '/'; // Retour à l'accueil
                }
            });

            // Fermer le modal de confirmation
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden');
                window.location.href = '/'; // Retour à l'accueil
            });

            // Calculer le prix initial
            calculatePrice();
        });

        // Note importante pour l'intégration Laravel :
        // 1. Remplacez 'YOUR_PAYPAL_CLIENT_ID' par votre vrai Client ID PayPal
        // 2. Créez une route POST pour traiter les réservations
        // 3. Ajoutez la validation côté serveur
        // 4. Intégrez avec votre base de données
        // 5. Configurez les notifications email
        // 6. Ajoutez la gestion des erreurs appropriée
        // 7. Implémentez la vérification des paiements PayPal côté serveur
    </script>
</body>
</html>