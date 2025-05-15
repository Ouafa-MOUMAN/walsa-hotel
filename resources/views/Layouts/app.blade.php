<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
        }
        .navbar {
            background-color: #4052b5;
        }
    </style>
</head>
<body>
    <nav class="navbar text-white px-6 py-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-2xl">Walsa Hotel</span>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="hover:text-gray-200">Accueil</a>
                <a href="#" class="hover:text-gray-200">À propos</a>
                <a href="#" class="hover:text-gray-200">Chambres</a>
                <a href="#" class="hover:text-gray-200">Services</a>
                <a href="#" class="hover:text-gray-200">Contact</a>
            </div>
            <div>
                @if(Auth::guard('client')->check() || session('is_admin'))
                    <!-- Already logged in -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white text-blue-800 px-4 py-2 rounded hover:bg-gray-100">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-800 px-4 py-2 rounded hover:bg-gray-100">
                        Connexion
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Walsa Hotel</h3>
                    <p class="text-gray-300">Un séjour de luxe et de confort pour tous nos clients.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact</h3>
                    <p class="text-gray-300">123 Avenue de l'Hôtel<br>75000 Paris, France</p>
                    <p class="text-gray-300">Téléphone: +33 1 23 45 67 89<br>Email: contact@walsahotel.com</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Liens rapides</h3>
                    <ul class="text-gray-300">
                        <li class="mb-2"><a href="#" class="hover:text-white">Nos chambres</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Réservations</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Services</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Walsa Hotel. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>