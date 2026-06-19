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

            // ============================================
            // WOOD THERAPY SERVICES
            // ============================================
            [
                'category' => 'Wood Therapy',
                'name' => 'Full Body',
                'price' => 120.00,
                'duration' => '60 mins',
                'description' => 'Full body wood therapy treatment targeting fat reduction, lymphatic drainage, and body contouring.',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'category' => 'Wood Therapy',
                'name' => 'Half Body',
                'price' => 75.00,
                'duration' => '45 mins',
                'description' => 'Focused wood therapy treatment for either upper or lower body to improve circulation and tone.',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'category' => 'Wood Therapy',
                'name' => 'Brazilian Contouring',
                'price' => 95.00,
                'duration' => '45 mins',
                'description' => 'Specialized wood therapy targeting the waist, hips, and buttocks for shaping and contour enhancement.',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'category' => 'Wood Therapy',
                'name' => 'Combo',
                'price' => 110.00,
                'duration' => '60 mins',
                'description' => 'Combination wood therapy session focusing on multiple body areas for enhanced sculpting results.',
                'sort_order' => 11,
                'is_active' => true,
            ],

            // ============================================
            // BRAIDS SERVICES
            // ============================================
            [
                'category' => 'Braids',
                'name' => 'Boho Braids (Bob)',
                'price' => 95.00,
                'duration' => '4 hours',
                'description' => 'Boho braids bob style. Synthetic hair is not accepted for a full head of curls. Additional £35 applies for a fuller look.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Braids',
                'name' => 'Boho Braids (Mid Back)',
                'price' => 110.00,
                'duration' => '6 hours',
                'description' => 'Boho braids mid-back length. Additional £35 applies for a fuller look.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Braids',
                'name' => 'Boho Braids (Long)',
                'price' => 150.00,
                'duration' => '8 hours',
                'description' => 'Boho braids long length. Additional £35 applies for a fuller look.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Braids',
                'name' => 'Box Braids (Bob)',
                'price' => 75.00,
                'duration' => '4 hours',
                'description' => 'Classic box braids bob style.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Braids',
                'name' => 'Box Braids (Mid Back)',
                'price' => 95.00,
                'duration' => '6 hours',
                'description' => 'Classic box braids mid-back length.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'category' => 'Braids',
                'name' => 'Box Braids (Long)',
                'price' => 125.00,
                'duration' => '8 hours',
                'description' => 'Classic box braids long length.',
                'sort_order' => 6,
                'is_active' => true,
            ],

            // ============================================
            // FRENCH CURLS SERVICES
            // ============================================
            [
                'category' => 'French Curls',
                'name' => 'French Curls (Bob)',
                'price' => 90.00,
                'duration' => '8 hours',
                'description' => 'French curls bob style. Client must provide fine pre-curled synthetic extensions. Minimum 3 x 100g bundles required. Additional £30 applies for a fuller look.',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'category' => 'French Curls',
                'name' => 'French Curls (Long)',
                'price' => 140.00,
                'duration' => '8 hours',
                'description' => 'French curls long style. Client must provide fine pre-curled synthetic extensions. Minimum 5 x 100g bundles required. Additional £30 applies for a fuller look.',
                'sort_order' => 8,
                'is_active' => true,
            ],

            // ============================================
            // IN-FEEDS SERVICES
            // ============================================
            [
                'category' => 'In-Feeds',
                'name' => '8-10 Plaits All Back',
                'price' => 60.00,
                'duration' => '4 hours',
                'description' => 'In-feed braids with 8 to 10 plaits all back.',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => '15-25 Plaits All Back',
                'price' => 65.00,
                'duration' => '4 hours',
                'description' => 'In-feed braids with 15 to 25 plaits all back.',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => 'Fulani With Braids',
                'price' => 110.00,
                'duration' => '6 hours',
                'description' => 'Traditional Fulani braids style.',
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => 'In-Feeds Pony',
                'price' => 95.00,
                'duration' => '5 hours',
                'description' => 'In-feed braided ponytail style.',
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => 'Micro Twist',
                'price' => 95.00,
                'duration' => '5 hours',
                'description' => 'Micro twist hairstyle.',
                'sort_order' => 13,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => 'Twist (Bob)',
                'price' => 70.00,
                'duration' => '4 hours',
                'description' => 'Twist hairstyle in bob length.',
                'sort_order' => 14,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => 'Twist (Mid Back)',
                'price' => 90.00,
                'duration' => '5 hours',
                'description' => 'Twist hairstyle in mid-back length.',
                'sort_order' => 15,
                'is_active' => true,
            ],
            [
                'category' => 'In-Feeds',
                'name' => 'Twist (Long)',
                'price' => 145.00,
                'duration' => '6 hours',
                'description' => 'Twist hairstyle in long length.',
                'sort_order' => 16,
                'is_active' => true,
            ],

            // ============================================
            // WEAVE SERVICES
            // ============================================
            [
                'category' => 'Weave',
                'name' => 'Leave Out',
                'price' => 75.00,
                'duration' => '5 hours',
                'description' => 'Weave installation with leave-out.',
                'sort_order' => 17,
                'is_active' => true,
            ],
            [
                'category' => 'Weave',
                'name' => 'Half Up and Down',
                'price' => 70.00,
                'duration' => '5 hours',
                'description' => 'Half up, half down weave style.',
                'sort_order' => 18,
                'is_active' => true,
            ],
            [
                'category' => 'Weave',
                'name' => 'Pony',
                'price' => 55.00,
                'duration' => '4 hours 10 minutes',
                'description' => 'Weave ponytail installation.',
                'sort_order' => 19,
                'is_active' => true,
            ],
            [
                'category' => 'Weave',
                'name' => 'Wig Installation 4x4 / 6x6 / 7x7',
                'price' => 90.00,
                'duration' => '4 hours',
                'description' => 'Professional wig installation for 4x4, 6x6, and 7x7 wigs.',
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'category' => 'Weave',
                'name' => 'Frontal Installation',
                'price' => 120.00,
                'duration' => '4 hours',
                'description' => 'Professional frontal wig installation service.',
                'sort_order' => 21,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
