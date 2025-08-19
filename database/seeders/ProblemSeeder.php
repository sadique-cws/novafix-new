<?php

namespace Database\Seeders;

use App\Models\Problem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $problems = [
            [
                'name' => 'Not open',
                'model_id' => 1
            ],
            [
                'name' => 'Display Lack',
                'model_id' => 2
            ],
            [
                'name' => 'Power Failure',
                'model_id' => 3
            ],
            [
                'name' => 'Call Remove',
                'model_id' => 4
            ],
            [
                'name' => 'Something Else',
                'model_id' => 5
            ],
        ];

        foreach ($problems as $problem) {
            Problem::updateOrCreate(
                ['name' => $problem['name'], 'model_id' => $problem['model_id']],
                $problem
            );
        }
    }
}
