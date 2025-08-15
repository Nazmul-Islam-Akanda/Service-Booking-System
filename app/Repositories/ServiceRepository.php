<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{
    public function getActiveServices()
    {
        return Service::where('status', 'active')->get();
    }
}
