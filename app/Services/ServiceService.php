<?php

namespace App\Services;

use App\Repositories\ServiceRepository;

class ServiceService
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
}
