<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addons = [
            [
                'name' => 'Hair Installation',
                'slug' => 'hair-installation',
                'price' => 25.00,
                'category' => 'Wig Services',
                'description' => 'Professional hair installation service',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Wig Styling',
                'slug' => 'wig-styling',
                'price' => 20.00,
                'category' => 'Wig Services',
                'description' => 'Custom wig styling and shaping',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bleaching Knots',
                'slug' => 'bleaching-knots',
                'price' => 15.00,
                'category' => 'Wig Services',
                'description' => 'Professional bleaching of wig knots',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Plucking',
                'slug' => 'plucking',
                'price' => 15.00,
                'category' => 'Wig Services',
                'description' => 'Natural hairline plucking',
                'sort_order' => 4,
                'is_active' => true,
            ]
        ];

        foreach ($addons as $addon) {
            Addon::create($addon);
        }
    }
}
