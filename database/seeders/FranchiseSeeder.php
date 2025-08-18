<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FranchiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $states = ['California', 'Texas', 'Florida', 'New York', 'Illinois'];
        $statuses = ['active', 'inactive', 'pending'];

        for ($i = 0; $i < 20; $i++) {
            $franchiseData[] = [
                'franchise_name'   => $faker->company . ' Franchise',
                'contact_no'      => $faker->numerify('+91##########'),
                'email'           => $faker->unique()->safeEmail,
                'password'        => Hash::make('password123'),
                'aadhar_no'       => $faker->optional(70)->numerify('############'),
                'pan_no'          => $faker->optional(80)->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
                'ifsc_code'       => $faker->optional(60)->regexify('[A-Z]{4}0[A-Z0-9]{6}'),
                'bank_name'       => $faker->optional(60)->company,
                'account_no'      => $faker->optional(50)->numerify('##############'),
                'street'          => $faker->streetAddress,
                'city'            => $faker->city,
                'district'        => $faker->city,
                'pincode'         => $faker->postcode,
                'state'           => $faker->randomElement($states),
                'country'         => 'USA',
                'doc'             => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'status'          => $faker->randomElement($statuses),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        // Insert data in chunks
        foreach (array_chunk($franchiseData, 5) as $chunk) {
            DB::table('franchises')->insert($chunk);
        }
    }
}