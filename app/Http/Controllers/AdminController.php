<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allBookings()
    {
        return Booking::with(['user', 'service'])->get();
    }
}
