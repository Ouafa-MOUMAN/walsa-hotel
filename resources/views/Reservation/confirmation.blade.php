@section('title', 'Confirmation de réservation - Walsa Hotel')

@section('content')
<div class="min-h-screen py-8 px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Réservation Confirmée</h1>
            <p class="text-white opacity-90">Votre réservation a été enregistrée avec succès</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Message de succès -->
            <div class="text-center mb-8">
                <div class="text-green-500 text-6xl mb-4">✓</div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Merci pour votre réservation !</h2>
                <p class="text-gray-600">Numéro de réservation: <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Détails de la réservation -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Détails de la réservation</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Client:</span>
                            <span class="font-semibold">{{ $booking->first_name }} {{ $booking->last_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold">{{ $booking->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Téléphone:</span>
                            <span class="font-semibold">{{ $booking->phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date d'arrivée:</span>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date de départ:</span>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre de nuits:</span>
                            <span class="font-semibold">{{ $booking->nights }}</span>
                        </div>
                    </div>
                </div>

                <!-- Détails de la chambre -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Détails de la chambre</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Chambre:</span>
                            <span class="font-semibold">{{ $booking->room->room_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-semibold">{{ $booking->room->room_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Capacité:</span>
                            <span class="font-semibold">{{ $booking->room->capacity }} personne(s)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Étage:</span>
                            <span class="font-semibold">{{ $booking->room->room_floor }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prix par nuit:</span>
                            <span class="font-semibold">{{ number_format($booking->price_per_night, 0) }} $</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif des coûts -->
            <div class="mt-8 bg-blue-50 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Récapitulatif des coûts</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Sous-total ({{ $booking->nights }} nuit(s)):</span>
                        <span>{{ number_format($booking->subtotal, 2) }} $</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Taxes (10%):</span>
                        <span>{{ number_format($booking->taxes, 2) }} $</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total:</span>
                        <span class="text-green-600">{{ number_format($booking->total_price, 2) }} $</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 text-center space-x-4">
                <a href="{{ route('home') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                    Retour à l'accueil
                </a>
                <a href="{{ route('booking.my-bookings') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                    Mes réservations
                </a>
            </div>

            <!-- Information supplémentaire -->
            <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h4 class="font-semibold text-yellow-800 mb-2">Informations importantes:</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Un email de confirmation vous sera envoyé sous peu</li>
                    <li>• Veuillez vous présenter à la réception avec une pièce d'identité</li>
                    <li>• L'heure d'arrivée est à partir de 14h00</li>
                    <li>• L'heure de départ est avant 12h00</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection