<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create($room_id)
    {
        $room = Room::findOrFail($room_id);
        
        // Vérifier si la chambre est disponible
        if ($room->status !== 'Available') {
            return redirect()->route('home')->with('error', 'Cette chambre n\'est pas disponible pour la réservation.');
        }
        
        return view('reservations.booking', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'nights' => 'required|integer|min:1|max:365',
        ]);

        $room = Room::findOrFail($request->room_id);
        
        // Vérifier si la chambre est encore disponible
        if ($room->status !== 'Available') {
            return back()->with('error', 'Cette chambre n\'est plus disponible.');
        }

        // Vérifier les conflits de dates
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        
        $conflictingBookings = Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'Cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })
            ->exists();

        if ($conflictingBookings) {
            return back()->with('error', 'Cette chambre est déjà réservée pour les dates sélectionnées.');
        }

        // Calculer le prix total
        $subtotal = $request->nights * $room->price_per_night;
        $taxes = $subtotal * 0.1; // 10% de taxes
        $totalPrice = $subtotal + $taxes;

        // Créer la réservation
        $booking = Booking::create([
            'client_id' => Auth::guard('client')->id(),
            'room_id' => $request->room_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'nights' => $request->nights,
            'total_price' => $totalPrice,
            'status' => 'Confirmed',
            'booking_date' => now(),
        ]);

        // Optionnel : Mettre à jour le statut de la chambre si nécessaire
        // $room->update(['status' => 'Reserved']);

        return redirect()->route('booking.show', $booking->id)
            ->with('success', 'Votre réservation a été confirmée avec succès !');
    }

    public function show($id)
    {
        $booking = Booking::with('room')
            ->where('client_id', Auth::guard('client')->id())
            ->findOrFail($id);
            
        return view('reservations.confirmation', compact('booking'));
    }
}