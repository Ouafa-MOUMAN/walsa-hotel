<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->get();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name' => 'required|string|max:255|unique:rooms',
            'room_type' => 'required|string|max:255',
            'room_floor' => 'required|string|max:255',
            'status' => ['required', Rule::in(Room::getStatuses())],
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $imagePath;
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
                        ->with('success', 'Chambre ajoutée avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_name' => 'required|string|max:255|unique:rooms,room_name,' . $room->id,
            'room_type' => 'required|string|max:255',
            'room_floor' => 'required|string|max:255',
            'status' => ['required', Rule::in(Room::getStatuses())],
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            
            $imagePath = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $imagePath;
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
                        ->with('success', 'Chambre modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // Supprimer l'image associée
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
                        ->with('success', 'Chambre supprimée avec succès !');
    }
}
