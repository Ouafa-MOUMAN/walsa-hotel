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
        /* Responsive */
        @media (max-width: 768px) {
            .hotel-main-image {
                height: 50vh;
            }
            
            .room-image, .map-container {
                height: 300px;
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
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>
</body>
</html>