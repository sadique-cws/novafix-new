<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $devices = [
            ['name' => 'Smartphone'],
            ['name' => 'Laptop'],
            ['name' => 'Tablet'],
            ['name' => 'Smartwatch'],
            ['name' => 'Desktop Computer'],
            
        ];

        foreach ($devices as $device) {
            Device::updateOrCreate(
                ['name' => $device['name']],
                $device
            );
        }
    }
}
