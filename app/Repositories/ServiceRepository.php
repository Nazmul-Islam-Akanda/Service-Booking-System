<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{
    public function getActiveServices()
    {
        return Service::where('status', 'active')->get();
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }
    public function update(Service $service, array $data): Service
    {
        $service->update($data);
        return $service;
    }

    public function findById(int $id): ?Service
    {
        return Service::find($id);
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }
    
}
