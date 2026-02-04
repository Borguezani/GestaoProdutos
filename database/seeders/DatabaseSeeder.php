<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'João Silva',
            'email' => 'usuario1@example.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'usuario2@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            CategoriaSeeder::class,
            ProdutoSeeder::class,
        ]);
    }
}
