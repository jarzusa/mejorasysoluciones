<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Receptor Seed
        \App\Models\Receptor::create([
            'name' => 'Receptor 1',
            'nit' => '01001010101',
        ]);

        \App\Models\Receptor::create([
            'name' => 'Receptor 2',
            'nit' => '020202020202',
        ]);

        
        // Trasmitter Seed
        \App\Models\Trasmitter::create([
            'name' => 'Trasmitter 1',
            'nit' => '000000111111',
        ]);

        \App\Models\Trasmitter::create([
            'name' => 'Trasmitter 2',
            'nit' => '0000002222222',
        ]);

        // Items Seed
        \App\Models\Items::create([
            'name' => 'Colgate',
            'precio' => '1000',
            'cantidad' => 20,
        ]);

        \App\Models\Items::create([
            'name' => 'Pepino',
            'precio' => '250',
            'cantidad' => 30,
        ]);

        \App\Models\Items::create([
            'name' => 'Lapicero',
            'precio' => '900',
            'cantidad' => 65,
        ]);

        \App\Models\Items::create([
            'name' => 'Cuaderno',
            'precio' => '3200',
            'cantidad' => 25,
        ]);
    }
}
