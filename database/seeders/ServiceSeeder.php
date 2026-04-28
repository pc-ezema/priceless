<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            // ============================================
            // HAIR CARE & STYLING SERVICES
            // ============================================
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Braid Removal',
                'price' => 60.00,
                'duration' => '1h 45m',
                'description' => 'Professional braid removal with care to prevent breakage',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Virgin Hair Relaxer',
                'price' => 120.00,
                'duration' => '2h',
                'description' => 'Gentle relaxing treatment for virgin hair',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Relaxer',
                'price' => 80.00,
                'duration' => '2h',
                'description' => 'Professional hair relaxing service',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Wash & Blow Dry',
                'price' => 30.00,
                'duration' => '1h',
                'description' => 'Luxury wash and professional blow dry',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Wash, Cut & Blow Dry',
                'price' => 55.00,
                'duration' => '1h',
                'description' => 'Complete wash, precision cut, and blow dry',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Wash, Cut & Straighten',
                'price' => 65.00,
                'duration' => '1h 45m',
                'description' => 'Wash, cut, and professional straightening',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Cornrow for Wigs',
                'price' => 20.00,
                'duration' => null,
                'description' => 'Perfect cornrow base for wig application',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Sleek Ponytail',
                'price' => 75.00,
                'duration' => '1h 20m',
                'description' => 'Sleek, polished ponytail styling',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Frontal Ponytail',
                'price' => 120.00,
                'duration' => '3h',
                'description' => 'Full frontal ponytail installation and styling',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Silk Press',
                'price' => 60.00,
                'duration' => '2h',
                'description' => 'Silky smooth press with heat protection',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'category' => 'Hair Care & Styling',
                'name' => 'Makeup',
                'price' => 60.00,
                'duration' => '1h 40m',
                'description' => 'Professional makeup application for any occasion',
                'sort_order' => 11,
                'is_active' => true,
            ],

            // ============================================
            // WIG SERVICES
            // ============================================
            [
                'category' => 'Wig Services',
                'name' => 'Closure Wigs (4×4–7×7)',
                'price' => 110.00,
                'duration' => null,
                'description' => 'Includes bleaching knots, plucking, and wig making',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Wig Services',
                'name' => 'Frontal Wigs',
                'price' => 130.00,
                'duration' => null,
                'description' => 'Includes bleaching knots, plucking, and wig making',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Wig Services',
                'name' => 'Frontal Replacement',
                'price' => 110.00,
                'duration' => null,
                'description' => 'Frontal replacement with unit wash included',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Wig Services',
                'name' => 'Closure Replacement',
                'price' => 85.00,
                'duration' => '30 mins',
                'description' => 'Professional closure replacement service',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Wig Services',
                'name' => 'Revamps',
                'price' => 50.00,
                'duration' => null,
                'description' => 'Wig revamp service - price starting from £50',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'category' => 'Wig Services',
                'name' => 'Braids',
                'price' => 120.00,
                'duration' => null,
                'description' => 'Professional braiding service - price starting from £120',
                'sort_order' => 6,
                'is_active' => true,
            ],

            // ============================================
            // WAXING SERVICES
            // ============================================
            [
                'category' => 'Waxing Services',
                'name' => 'Bikini Wax',
                'price' => 30.00,
                'duration' => '30 mins',
                'description' => 'Gentle bikini waxing service',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'G-String Wax',
                'price' => 36.00,
                'duration' => '30 mins',
                'description' => 'Precision G-string waxing',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'Brazilian',
                'price' => 45.00,
                'duration' => '45 mins',
                'description' => 'Complete Brazilian wax treatment',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'Hollywood',
                'price' => 45.00,
                'duration' => '45 mins',
                'description' => 'Complete Hollywood wax (everything removed)',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'Underarm',
                'price' => 15.00,
                'duration' => '30 mins',
                'description' => 'Quick and gentle underarm wax',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'Forearm',
                'price' => 15.00,
                'duration' => '30 mins',
                'description' => 'Smooth forearm waxing',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'Half Leg Wax',
                'price' => 25.00,
                'duration' => '30 mins',
                'description' => 'Half leg wax (knee to ankle)',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'category' => 'Waxing Services',
                'name' => 'Full Leg Wax',
                'price' => 35.00,
                'duration' => '45 mins',
                'description' => 'Complete leg wax from thigh to ankle',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
