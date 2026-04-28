<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            "email" => "admin@pricelessbeauty.co.uk"
        ], [
            'name' => 'Princeless Admin',
            'email' => 'admin@pricelessbeauty.co.uk',
            'password' => bcrypt('admin@pricelessbeauty.co.uk') // Use a secure password in production
        ]);
    }
}
