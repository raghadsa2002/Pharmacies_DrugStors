<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Pharmacy::create([
        'name' => 'pharmacy',
        'email' => 'pharmacy@gmail.com',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'status' => '1',
        'phone' => '2234567',
        'city' => 'Damascus',
        'address' => 'Mazzeh',
        'img' => 'PharmacyImage/pharmacy1.jpg',
        'created_by' => '1',
        ]);
    }
}
