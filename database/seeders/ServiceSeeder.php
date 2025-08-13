<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'AC Repair',
            'description' => 'Air Conditioner repair service',
            'price' => 1000,
        ]);

        Service::create([
            'name' => 'Plumbing',
            'description' => 'Fix leaks and pipes',
            'price' => 500,
        ]);
    }
}
