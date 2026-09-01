<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hospital::create([
            'id' => 1,
            'hospital_name' => 'General Health Medical Center',
            'hospital_address' => '123 Health Ave, Central District',
        ]);
    }
}
