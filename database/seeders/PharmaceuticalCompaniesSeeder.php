<?php

namespace Database\Seeders;

use App\Models\PharmaceuticalCompanies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PharmaceuticalCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        PharmaceuticalCompanies::create([
            'name' => 'Pharmaceutical Companies',
            'phone' => '0987654321',
            'status' => '1',
            'city' => 'Damas',
            'address' => 'Malki',
            'created_by' => '1',
        ]);
    }
}
