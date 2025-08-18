<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Added missing import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReceptionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        
        // Get existing franchise IDs to use as foreign keys
        $franchiseIds = DB::table('franchises')->pluck('id')->toArray();
        
        $receptioners = [];
        $statuses = ['1', '0']; // Active or Inactive

        for ($i = 0; $i < 50; $i++) {
            $receptioners[] = [
                'franchise_id' => count($franchiseIds) ? $faker->randomElement($franchiseIds) : null,
                'name'        => $faker->name,
                'contact'     => $faker->numerify('+91##########'),
                'email'       => $faker->unique()->safeEmail,
                'aadhar'      => $faker->numerify('############'),
                'pan'         => $faker->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
                'address'     => $faker->address,
                'salary'      => $faker->numberBetween(15000, 40000),
                'status'      => $faker->randomElement($statuses),
                'password'    => Hash::make('password'),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // Insert in chunks for better performance
        foreach (array_chunk($receptioners, 25) as $chunk) {
            DB::table('receptioners')->insert($chunk);
        }
    }
}