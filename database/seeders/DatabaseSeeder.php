<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Franchise;
use App\Models\Receptioners;
use App\Models\Staff;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use App\Models\Customer;
use App\Models\Payment;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $password = Hash::make('password');

        // 1. Call Independent Data Seeders (Brands, Devices, Problems, etc.)
        $this->call([
           DeviceSeeder::class,
           BrandSeeder::class,
           ModelSeeder::class,
           ProblemSeeder::class,
           QuestionSeeder::class,
           TreeExplorerSampleSeeder::class,
        ]);

        // 2. Create Service Categories if none exist
        $categories = ['Mobile Repair', 'Laptop Repair', 'Tablet Repair'];
        $categoryIds = [];
        foreach ($categories as $cat) {
            $category = ServiceCategory::firstOrCreate(['name' => $cat]);
            $categoryIds[] = $category->id;
        }

        // 3. Create SuperAdmin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => $password, // unified password
                'is_admin' => true,
            ]
        );

        // 4. Generate Franchises and their hierarchical data
        for ($i = 1; $i <= 5; $i++) {
            // A. Create Franchise
            $franchise = Franchise::create([
                'franchise_name'   => $faker->company . " Branch",
                'contact_no'      => $faker->numerify('9#########'),
                'email'           => "franchise{$i}@gmail.com",
                'password'        => $password,
                'street'          => $faker->streetAddress,
                'city'            => $faker->city,
                'district'        => $faker->city,
                'state'           => $faker->state,
                'pincode'         => $faker->postcode,
                'country'         => 'India',
                'status'          => 'active',
                'doc'             => now()->subMonths(rand(1, 12)),
            ]);

            // B. Create Receptionists for this Franchise
            $receptionists = [];
            for ($j = 1; $j <= 2; $j++) {
                $receptionists[] = Receptioners::create([
                    'franchise_id' => $franchise->id,
                    'name'         => "Receptionist {$i}-{$j}",
                    'email'        => "receptionist{$i}{$j}@gmail.com",
                    'contact'      => $faker->numerify('9#########'),
                    'password'     => $password,
                    'status'       => 'active',
                    'salary'       => $faker->numberBetween(15000, 25000),
                    'aadhar'       => $faker->numerify('############'),
                    'pan'          => $faker->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
                    'address'      => $faker->address,
                ]);
            }

            // C. Create Staff/Technicians for this Franchise
            $staffs = [];
            for ($k = 1; $k <= 3; $k++) {
                $staffs[] = Staff::create([
                    'franchise_id'          => $franchise->id,
                    'service_categories_id' => $faker->randomElement($categoryIds),
                    'name'                  => "Technician {$i}-{$k}",
                    'email'                 => "tech{$i}{$k}@gmail.com",
                    'contact'               => $faker->numerify('9#########'),
                    'password'              => $password,
                    'status'                => 'active',
                    'salary'                => $faker->numberBetween(20000, 35000),
                    'aadhar'                => $faker->numerify('############'),
                    'pan'                   => $faker->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
                    'address'               => $faker->address,
                ]);
            }

            // D. Create Service Requests & Payments for this Franchise
            for ($r = 1; $r <= 10; $r++) {
                $receptionist = $faker->randomElement($receptionists);
                $technician = $faker->randomElement($staffs);
                $amount = $faker->randomFloat(2, 500, 5000);

                // Create Customer
                $ownerName = $faker->name;
                $contact = $faker->numerify('9#########');
                $email = $faker->safeEmail;

                Customer::updateOrCreate(
                    [
                        'contact' => $contact,
                        'franchise_id' => $franchise->id
                    ],
                    [
                        'name' => $ownerName,
                        'email' => $email,
                    ]
                );

                $request = ServiceRequest::create([
                    'franchise_id'          => $franchise->id,
                    'receptioners_id'       => $receptionist->id,
                    'technician_id'         => $technician->id,
                    'service_categories_id' => $technician->service_categories_id,
                    'service_code'          => strtoupper($faker->bothify('REQ###??')),
                    'owner_name'            => $ownerName,
                    'contact'               => $contact,
                    'email'                 => $email,
                    'product_name'          => 'Device ' . $faker->word,
                    'brand'                 => 'Brand ' . $faker->word,
                    'color'                 => $faker->safeColorName,
                    'problem'               => $faker->sentence,
                    'service_amount'        => $amount,
                    'status'                => $faker->randomElement([1, 2, 3]), // e.g. pending, in-progress, completed
                    'delivery_status'       => 0,
                    'estimate_delivery'     => now()->addDays(rand(1, 5)),
                    'last_update'           => now(),
                ]);

                // Create Payment for this Service Request
                Payment::create([
                    'service_request_id' => $request->id,
                    'amount'             => $amount,
                    'total_amount'       => $amount,
                    'status'             => $faker->randomElement(['pending', 'completed']),
                    'payment_method'     => 'cash',
                    'staff_id'           => $technician->id,
                    'received_by'        => $receptionist->id,
                ]);
            }
        }
    }
}
