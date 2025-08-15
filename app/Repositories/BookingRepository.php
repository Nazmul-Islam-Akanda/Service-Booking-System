<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    public function create(array $data): Booking
    {
        return Booking::create($data);
    }
}