<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Styles généraux */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }
        /* Navigation */
        nav {
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        /* Section Home */
        .hotel-main-image {
            height: 100vh;
            background-image: url('/images/hotel-pool.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        /* Section About */
        .room-image {
            height: 400px;
            background-image: url('/images/hotel-room.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        /* Section Contact */
        .map-container {
            height: 400px;
            background-image: url('/images/hotel-map.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .cancel-btn {
            background-color: #10B981;
            color: white;
            transition: background-color 0.3s;
        }
        .submit-btn {
            background-color: #10B981;
            color: white;
            transition: background-color 0.3s;
        }
        .cancel-btn:hover, .submit-btn:hover {
            background-color: #059669;
        }
        
        /* Styles pour la section des chambres */
        .room-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .room-card:hover {
            transform: translateY(-2px);
        }
        .room-image-card {
            height: 200px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .broke-btn {
            background-color: #10B981;
            color: white;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .broke-btn:hover {
            background-color: #059669;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hotel-main-image {
                height: 50vh;
            }
            
            .room-image, .map-container {
                height: 300px;
            }
            
            .rooms-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .rooms-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1025px) {
            .rooms-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-black text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="logo">
                <!-- Logo peut être ajouté ici -->
            </div>
            <div class="nav-links">
                <ul class="flex space-x-6">
                    <li><a href="#home" class="hover:text-gray-300">Home</a></li>
                    <li><a href="#about" class="hover:text-gray-300">About</a></li>
                    <li><a href="#rooms" class="hover:text-gray-300">Rooms</a></li>
                    <li><a href="#contact" class="hover:text-gray-300">contact</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-gray-300">Log in</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-gray-300">Sign up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Home avec l'image de l'hôtel -->
    <section id="home" class="hotel-main-image">
        <!-- L'image est définie en CSS comme background -->
    </section>

    <!-- Section About -->
    <section id="about" class="py-16">
        <div class="container mx-auto">
            <h1 class="text-5xl font-bold mb-8">About</h1>
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 p-4">
                    <p class="text-lg">
                        Bienvenue sur le site de Walsa Hotel – votre havre de paix 
                        et d'élégance au cœur de Paris. Que vous 
                        voyagiez pour le plaisir, les affaires ou un moment de détente, 
                        notre hôtel allie confort moderne, service exceptionnel et 
                        emplacement idéal pour rendre votre séjour inoubliable.
                    </p>
                    <p class="text-lg mt-4">
                        Profitez de nos chambres et suites raffinées, de nos 
                        équipements haut de gamme et d'une gastronomie 
                        savoureuse, le tout dans une ambiance chaleureuse et 
                        sophistiquée. Réservez dès maintenant et vivez une 
                        expérience hôtelière d'exception !
                    </p>
                </div>
                <div class="md:w-1/2 p-4 room-image">
                    <!-- L'image est définie en CSS comme background -->
                </div>
            </div>
        </div>
    </section>

    <!-- Section Rooms -->
    <section id="rooms" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Filtres -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-5xl font-bold">Nos Chambres</h1>
                <div class="flex space-x-4">
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Type</label>
                        <select id="typeFilter" class="px-4 py-2 border rounded-lg bg-white">
                            <option value="">Tous les types</option>
                            <option value="Single rooms">Single rooms</option>
                            <option value="Double rooms">Double rooms</option>
                            <option value="Triple rooms">Triple rooms</option>
                            <option value="Deluxe">Deluxe</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Capacité</label>
                        <select id="capacityFilter" class="px-4 py-2 border rounded-lg bg-white">
                            <option value="">Toutes capacités</option>
                            <option value="1">1 personne</option>
                            <option value="2">2 personnes</option>
                            <option value="3">3 personnes</option>
                        </select>
                    </div>
                    <button id="searchBtn" class="mt-6 px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Search
                    </button>
                </div>
            </div>
            
            <!-- Grille des chambres -->
            <div id="roomsContainer" class="rooms-grid grid gap-6">
                <!-- Les chambres seront ajoutées ici dynamiquement -->
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact" class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <h1 class="text-5xl font-bold mb-8">contact</h1>
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 p-4">
                    <form id="contactForm" class="space-y-4">
                        <div>
                            <input type="text" placeholder="full name" class="w-full p-3 bg-gray-200 rounded">
                        </div>
                        <div>
                            <input type="email" placeholder="Email" class="w-full p-3 bg-gray-200 rounded">
                        </div>
                        <div>
                            <input type="tel" placeholder="Telephone" class="w-full p-3 bg-gray-200 rounded">
                        </div>
                        <div>
                            <textarea placeholder="Message" rows="5" class="w-full p-3 bg-gray-200 rounded"></textarea>
                        </div>
                        <div class="flex space-x-4">
                            <button type="button" class="cancel-btn px-6 py-2 rounded">Cancel</button>
                            <button type="submit" class="submit-btn px-6 py-2 rounded">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="md:w-1/2 p-4 map-container">
                    <!-- L'image est définie en CSS comme background -->
                </div>
            </div>
        </div>
    </section>

    <script>
        // Récupérer les données des chambres depuis Laravel
        const roomsData = @json($rooms);

        let filteredRooms = roomsData;

        function createRoomCard(room) {
            // Construire l'URL de l'image
            const imageUrl = room.image ? `/storage/${room.image}` : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&h=200&fit=crop';
            
            // Formater les équipements
            const amenities = room.amenities ? room.amenities.split(',').join(', ') : 'Aucun équipement spécifié';
            
            return `
                <div class="room-card bg-white">
                    <div class="room-image-card" style="background-image: url('${imageUrl}')"></div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-1">${room.room_name}</h3>
                        <p class="text-gray-600 mb-1">${room.room_type}</p>
                        <p class="text-gray-600 mb-1">${room.capacity} personne${room.capacity > 1 ? 's' : ''}</p>
                        <p class="text-gray-600 mb-1">${room.room_floor}</p>
                        <p class="text-sm text-gray-500 mb-2">${amenities}</p>
                        <p class="text-red-500 font-bold mb-3">${room.price_per_night} $/night</p>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full mb-2 ${room.status === 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${room.status}
                        </span>
                        <button class="broke-btn w-full py-2 rounded font-medium" onclick="redirectToLogin()">
                            Réserver
                        </button>
                    </div>
                </div>
            `;
        }

        function displayRooms(rooms) {
            const container = document.getElementById('roomsContainer');
            if (rooms.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500 col-span-full">Aucune chambre trouvée avec ces critères.</p>';
            } else {
                container.innerHTML = rooms.map(room => createRoomCard(room)).join('');
            }
        }

        function filterRooms() {
            const typeFilter = document.getElementById('typeFilter').value;
            const capacityFilter = document.getElementById('capacityFilter').value;

            filteredRooms = roomsData.filter(room => {
                const typeMatch = !typeFilter || room.room_type === typeFilter;
                const capacityMatch = !capacityFilter || room.capacity.toString() === capacityFilter;
                return typeMatch && capacityMatch && room.status === 'Available';
            });

            displayRooms(filteredRooms);
        }

        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Afficher toutes les chambres disponibles au chargement
            displayRooms(roomsData.filter(room => room.status === 'Available'));

            // Ajouter les événements de filtrage
            document.getElementById('searchBtn').addEventListener('click', filterRooms);
            document.getElementById('typeFilter').addEventListener('change', filterRooms);
            document.getElementById('capacityFilter').addEventListener('change', filterRooms);

            // Référencer le formulaire
            const contactForm = document.getElementById('contactForm');
            
            // Fonction pour valider les champs du formulaire
            function validateForm() {
                const fullName = contactForm.querySelector('input[type="text"]').value;
                const email = contactForm.querySelector('input[type="email"]').value;
                const telephone = contactForm.querySelector('input[type="tel"]').value;
                const message = contactForm.querySelector('textarea').value;
                
                // Validation simple
                if (fullName === '') {
                    alert('Veuillez entrer votre nom complet');
                    return false;
                }
                
                if (email === '') {
                    alert('Veuillez entrer votre email');
                    return false;
                }
                
                // Validation basique d'email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Veuillez entrer un email valide');
                    return false;
                }
                
                if (telephone === '') {
                    alert('Veuillez entrer votre numéro de téléphone');
                    return false;
                }
                
                if (message === '') {
                    alert('Veuillez entrer un message');
                    return false;
                }
                
                return true;
            }
            
            // Gérer la soumission du formulaire
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    // Simuler l'envoi du formulaire
                    alert('Votre message a été envoyé avec succès!');
                    contactForm.reset();
                    
                    // Dans un cas réel, vous enverriez les données à votre backend Laravel ici
                    // Par exemple avec fetch ou axios
                }
            });
            
            // Gérer le bouton d'annulation
            const cancelBtn = contactForm.querySelector('.cancel-btn');
            cancelBtn.addEventListener('click', function() {
                contactForm.reset();
            });
            
            // Gérer la navigation fluide
            document.querySelectorAll('nav a').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    // Ne pas intercepter les liens vers les pages de connexion et d'inscription
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('href');
                        const targetSection = document.querySelector(targetId);
                        
                        window.scrollTo({
                            top: targetSection.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>