<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Wellington di Giacomo',
            'email' => 'wellgiacomo@hotmail.com',
            'is_admin' => true,
            'document_number' => '044.366.038-73',
        ]);

        $this->call(ActiviesSeeder::class);
    }
}
