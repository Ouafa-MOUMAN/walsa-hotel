@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bienvenue, Administrateur</h2>
            <p class="text-gray-600">Voici votre tableau de bord d'administration du Walsa Hotel.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Gestion des Réservations</h3>
                <p class="text-gray-600 mb-4">Consultez et gérez toutes les réservations de l'hôtel.</p>
                <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">Voir les réservations</a>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Gestion des Chambres</h3>
                <p class="text-gray-600 mb-4">Ajoutez, modifiez ou supprimez des chambres de l'hôtel.</p>
                <a href="#" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">Gérer les chambres</a>
            </div>
            
            <div class="bg-yellow-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Gestion des Clients</h3>
                <p class="text-gray-600 mb-4">Consultez et gérez les comptes clients.</p>
                <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors">Voir les clients</a>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Statistiques</h3>
                <p class="text-gray-600 mb-4">Consultez les rapports et statistiques de l'hôtel.</p>
                <a href="#" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors">Voir les statistiques</a>
            </div>
            
            <div class="bg-red-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Paramètres</h3>
                <p class="text-gray-600 mb-4">Configurez les paramètres généraux de l'application.</p>
                <a href="#" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">Paramètres</a>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Journal d'activité</h3>
                <p class="text-gray-600 mb-4">Consultez les journaux d'activité et de sécurité.</p>
                <a href="#" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">Voir les journaux</a>
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