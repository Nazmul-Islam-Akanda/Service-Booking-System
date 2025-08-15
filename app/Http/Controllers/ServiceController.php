<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\ServiceService;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * @OA\Get(
     *     path="/api/services",
     *     summary="Get list of active services",
     *     description="Returns a list of all active services from the system. Requires Bearer Token authentication.",
     *     tags={"Services"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Active services retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="AC Repair"),
     *                     @OA\Property(property="description", type="string", example="Air Conditioner repair service"),
     *                     @OA\Property(property="price", type="number", example=1000),
     *                     @OA\Property(property="status", type="string", example="active"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-15T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-15T10:00:00Z")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Active services retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="null", example=null),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="string", example="Something went wrong"),
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function services()
    {
        $services = $this->serviceService->listActiveServices();
        return $this->responseWithSuccess($services, 'Active services retrieved successfully',200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'message' => 'Validation failed.'], 422);
        }

        $service = Service::create($request->all());
        return response()->json($service, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'message' => 'Validation failed.'], 422);
        }
        
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return response()->json($service);
    }

    public function destroy($id)
    {
        Service::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
