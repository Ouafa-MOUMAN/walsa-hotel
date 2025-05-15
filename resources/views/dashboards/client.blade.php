@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6">Client Dashboard</h1>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bienvenue, {{ Auth::guard('client')->user()->prenom }} {{ Auth::guard('client')->user()->nom }}</h2>
            <p class="text-gray-600">Voici votre tableau de bord client du Walsa Hotel.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mes Réservations</h3>
                <p class="text-gray-600 mb-4">Consultez et gérez vos réservations actuelles et passées.</p>
                <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">Voir mes réservations</a>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Nouvelle Réservation</h3>
                <p class="text-gray-600 mb-4">Réservez une nouvelle chambre ou un service à l'hôtel.</p>
                <a href="#" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">Réserver maintenant</a>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mon Profil</h3>
                <p class="text-gray-600 mb-4">Modifiez vos informations personnelles et préférences.</p>
                <a href="#" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors">Éditer mon profil</a>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition-colors">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection