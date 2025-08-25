<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\Franchise;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
                'password' => 'password',
                'status' => 'active'
            ]);
            $franchises = collect([$franchise]);
        }

        $serviceCategories = ServiceCategory::all();
        if ($serviceCategories->isEmpty()) {
            // First, let's check what columns exist in the service_categories table
            $columns = DB::getSchemaBuilder()->getColumnListing('service_categories');
            
            // Create service categories with only the fields that exist in your table
            $serviceCategories = [
                ServiceCategory::create($this->getServiceCategoryData('AC Repair', $columns)),
                ServiceCategory::create($this->getServiceCategoryData('Plumbing', $columns)),
                ServiceCategory::create($this->getServiceCategoryData('Electrical', $columns))
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
                'password' => 'password',
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
                'password' => 'password',
                'franchise_id' => $franchises->first()->id,
                'service_categories_id' => $serviceCategories[2]->id,
            ]
        ];

        foreach ($staffData as $staff) {
            Staff::create($staff);
        }

        $this->command->info('Staff members seeded successfully!');
    }

    /**
     * Get service category data based on available columns
     */
    private function getServiceCategoryData($name, $columns)
    {
        $data = ['name' => $name];
        
        // Only include these fields if they exist in the table
        if (in_array('description', $columns)) {
            $data['description'] = "$name services";
        }
        
        if (in_array('status', $columns)) {
            $data['status'] = 'active';
        }
        
        return $data;
    }
}