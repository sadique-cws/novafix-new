<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Iphone',
                'device_id' => 1
            ],
            [
                'name' => 'Dell',
                'device_id' => 2
            ],
            [
                'name' => 'Samsung',
                'device_id' => 3
            ],
            [
                'name' => 'Hp',
                'device_id' => 4
            ],
            [
                'name' => 'Boat',
                'device_id' => 5
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name'], 'device_id' => $brand['device_id']],
                $brand
            );
        }
    }
}
