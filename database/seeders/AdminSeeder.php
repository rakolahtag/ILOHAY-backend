<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'prenom' => 'System',
            'email' => 'admin@ilohay.com',
            'password' => Hash::make('Admin@123'), // change-le après premier login
            'role' => 'admin',
            'cin' => '000000000000',
            'telephone' => '0340000000',
            'adresse' => 'Antananarivo',
            'pays_origine' => 'Madagascar',
            'nationalite' => 'Malgache',
            'genre' => 'Homme',
        ]);
    }
}
