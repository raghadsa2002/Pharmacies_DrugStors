<?php

namespace Database\Seeders;

use App\Models\StoreHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        StoreHouse::create([
            'name' => 'Store House',
            'email' => 'storehouse@gmail.com',
            'phone' => '0987654321',
            'status' => '1',
            'city' => 'Damas',
            'address' => 'Midan',
            'created_by' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

        ]);
    }
}
