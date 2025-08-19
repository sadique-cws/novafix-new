<?php

namespace Database\Seeders;

use App\Models\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            [
                'name' => 'ip30',
                'brand_id' => 1
            ],
            [
                'name' => 'i3',
                'brand_id' => 2
            ],
            [
                'name' => 'S 22',
                'brand_id' => 3
            ],
            [
                'name' => 'victus',
                'brand_id' => 4
            ],
            [
                'name' => 'Stroam call 2',
                'brand_id' => 5
            ],
        ];

        foreach ($models as $model) {
            Model::updateOrCreate(
                ['name' => $model['name'], 'brand_id' => $model['brand_id']],
                $model
            );
        }
    }

}
