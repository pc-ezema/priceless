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
        User::factory()->createOrUpdate([
            "email" => "admin@priceless.co.uk"
        ], [
            'name' => 'Princeless Admin',
            'email' => 'admin@priceless.co.uk',
            'password' => bcrypt('admin@priceless.co.uk') // Use a secure password in production
        ]);
    }
}
