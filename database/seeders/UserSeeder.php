<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios administradores
    

        User::create([
            'name' => 'Levi Quintero',
            'email' => 'quinterolevii87@gmail.com',
            'password' => Hash::make('admin123'),
        ])->assignRole('admin');

        User::create([
            'name' => 'Gilson Zuñiga',
            'email' => 'gilsonzuniga@gmail.com',
            'password' => Hash::make('admin123'),
        ])->assignRole('admin');

         

        // Usuarios auxiliares (9)
        $auxiliares = [
            ['name' => 'Luis Romero',     'email' => 'luis.romero@example.com'],
            ['name' => 'Diana Pérez',     'email' => 'diana.perez@example.com'],
            ['name' => 'Camilo Vargas',   'email' => 'camilo.vargas@example.com'],
            ['name' => 'Ana Ríos',        'email' => 'ana.rios@example.com'],
            ['name' => 'Juan Martínez',   'email' => 'juan.martinez@example.com'],
            ['name' => 'Carolina Torres', 'email' => 'carolina.torres@example.com'],
            ['name' => 'Mateo Gómez',     'email' => 'mateo.gomez@example.com'],
            ['name' => 'Sandra López',    'email' => 'sandra.lopez@example.com'],
            ['name' => 'Esteban Cruz',    'email' => 'esteban.cruz@example.com'],
        ];

        foreach ($auxiliares as $aux) {
            User::create([
                'name' => $aux['name'],
                'email' => $aux['email'],
                'password' => Hash::make('aux123'),
            ])->assignRole('aux');
        }
    }
}
