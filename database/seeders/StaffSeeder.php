<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\Franchise;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create necessary related records
        $franchises = Franchise::all();
        if ($franchises->isEmpty()) {
            $franchise = Franchise::create([
                'name' => 'Main Branch',
                'email' => 'main@example.com',
                'contact' => '1234567890',
                'address' => '123 Main Street',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'password' => Hash::make('password'),
                'status' => 'active'
            ]);
            $franchises = collect([$franchise]);
        }

        $serviceCategories = ServiceCategory::all();
        if ($serviceCategories->isEmpty()) {
            // Create service categories manually instead of using factory
            $serviceCategories = [
                ServiceCategory::create([
                    'name' => 'AC Repair',
                    'description' => 'Air conditioner repair and maintenance services',
                    'status' => 'active'
                ]),
                ServiceCategory::create([
                    'name' => 'Plumbing',
                    'description' => 'Plumbing services and repairs',
                    'status' => 'active'
                ]),
                ServiceCategory::create([
                    'name' => 'Electrical',
                    'description' => 'Electrical services and repairs',
                    'status' => 'active'
                ])
            ];
        }

        // Create staff members
        $staffData = [
            [
                'name' => 'Raj Sharma',
                'email' => 'technician@example.com',
                'contact' => '9876543210',
                'salary' => '25000',
                'status' => 'active',
                'aadhar' => '1234-5678-9012',
                'pan' => 'ABCDE1234F',
                'address' => '456 Tech Street, Mumbai',
                'password' => Hash::make('password'),
                'franchise_id' => $franchises->first()->id,
                'service_categories_id' => $serviceCategories[0]->id,
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'staff@example.com',
                'contact' => '8765432109',
                'salary' => '22000',
                'status' => 'active',
                'aadhar' => '2345-6789-0123',
                'pan' => 'BCDEF2345G',
                'address' => '789 Service Road, Delhi',
                'password' => Hash::make('password'),
                'franchise_id' => $franchises->first()->id,
                'service_categories_id' => $serviceCategories[1]->id,
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram@example.com',
                'contact' => '7654321098',
                'salary' => '28000',
                'status' => 'inactive',
                'aadhar' => '3456-7890-1234',
                'pan' => 'CDEFG3456H',
                'address' => '321 Worker Colony, Bangalore',
                'password' => Hash::make('password'),
                'franchise_id' => $franchises->first()->id,
                'service_categories_id' => $serviceCategories[2]->id,
            ]
        ];

        foreach ($staffData as $staff) {
            Staff::create($staff);
        }

        $this->command->info('Staff members seeded successfully!');
    }
}