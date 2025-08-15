<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookingService extends Controller
{
    protected $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        $this->bookingRepo = $bookingRepo;
    }

    public function createBooking(array $data)
    {
        $validator = Validator::make($data, [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors(), 'Validation failed.', 422);
        }

        $booking = $this->bookingRepo->create([
            'user_id' => auth()->id(),
            'service_id' => $data['service_id'],
            'booking_date' => $data['booking_date'],
        ]);

        return $this->responseWithSuccess($booking, 'Booking created successfully.', 201);
    }
}
