<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaboratoryService;

class LaboratoryServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed category for laboratory service with ID 2
        $service2 = LaboratoryService::find(2);
        if ($service2) {
            $service2->category = 'Urinalysis';
            $service2->save();
        }

        // Seed category for laboratory service with ID 3
        $service3 = LaboratoryService::find(3);
        if ($service3) {
            $service3->category = 'Hematology';
            $service3->save();
        }
    }
}
