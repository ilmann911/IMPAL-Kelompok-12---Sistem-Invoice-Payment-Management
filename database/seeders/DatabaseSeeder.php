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
        // Daftarkan InvoPaySeeder di sini agar otomatis ikut dieksekusi
        $this->call(InvoPaySeeder::class);

        // Data dummy bawaan untuk model User (bisa dipertahankan)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}