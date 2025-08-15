<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Repositories\ServiceRepository;
use Illuminate\Support\Facades\Validator;

class ServiceService extends Controller
{
    protected $serviceRepo;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    public function listActiveServices()
    {
        return $this->serviceRepo->getActiveServices();
    }

    public function createService(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors(), 'Validation failed.', 422);
        }

        $service = $this->serviceRepo->create($data);

        return $this->responseWithSuccess($service, 'Service created successfully.', 201);
    }

    public function updateService(array $data, int $id)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors(), 'Validation failed.', 422);
        }

        $service = $this->serviceRepo->findById($id);
        if (!$service) {
            return $this->responseWithError(null, 'Service not found.', 404);
        }
        $updatedService = $this->serviceRepo->update($service, $data);

        return $this->responseWithSuccess($updatedService, 'Service updated successfully.', 200);
    }

    public function deleteService(int $id)
    {
        $service = $this->serviceRepo->findById($id);
        if (!$service) {
            return $this->responseWithError(null, 'Service not found.', 404);
        }

        $this->serviceRepo->delete($service);

        return $this->responseWithSuccess(null, 'Service deleted successfully.', 200);
    }

}
