<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\BookingService;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }


    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Create a new booking",
     *     tags={"Bookings"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"service_id","booking_date"},
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="booking_date", type="string", format="date", example="2025-08-20")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="service_id", type="integer", example=1),
     *                 @OA\Property(property="booking_date", type="string", format="date", example="2025-08-20"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-15T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-15T12:00:00Z")
     *             ),
     *             @OA\Property(property="message", type="string", example="Booking created successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="service_id", type="array", @OA\Items(type="string"), example={"The service id field is required."}),
     *                 @OA\Property(property="booking_date", type="array", @OA\Items(type="string"), example={"The booking date field is required."})
     *             ),
     *             @OA\Property(property="message", type="string", example="Validation failed.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="null", example=null),
     *             @OA\Property(property="message", type="string", example="Unauthenticated or invalid token.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        return $this->bookingService->createBooking($request->all());
    }


    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     summary="Get all bookings of the authenticated user",
     *     tags={"Bookings"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Bookings retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=1),
     *                     @OA\Property(property="service_id", type="integer", example=1),
     *                     @OA\Property(property="booking_date", type="string", format="date", example="2025-08-20"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-15T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-15T12:00:00Z"),
     *                     @OA\Property(property="service", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Service Name")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Bookings retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="data", type="null", example=null),
     *             @OA\Property(property="message", type="string", example="Unauthenticated or invalid token.")
     *         )
     *     )
     * )
     */
    public function myBookings()
    {
        return $this->responseWithSuccess(auth()->user()->bookings()->with('service')->get(), 'Bookings retrieved successfully', 200);
    }
}
