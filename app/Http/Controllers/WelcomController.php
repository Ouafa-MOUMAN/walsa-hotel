<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class WelcomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('welcome', compact('rooms'));
    }
}