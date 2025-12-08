<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário Admin
        User::create([
            'name' => 'Administrador FASPM',
            'email' => 'admin@faspmpa.com.br',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'ativo' => true,
        ]);

        // Usuário Ouvidor
        User::create([
            'name' => 'Ouvidor FASPM',
            'email' => 'ouvidor@faspmpa.com.br',
            'password' => Hash::make('ouvidor123'),
            'role' => 'ouvidor',
            'ativo' => true,
        ]);

        // Usuário Secretário
        User::create([
            'name' => 'Secretário FASPM',
            'email' => 'secretario@faspmpa.com.br',
            'password' => Hash::make('secretario123'),
            'role' => 'secretario',
            'ativo' => true,
        ]);

        $this->command->info('Usuários iniciais criados com sucesso!');
        $this->command->info('Admin: admin@faspmpa.com.br / admin123');
        $this->command->info('Ouvidor: ouvidor@faspmpa.com.br / ouvidor123');
        $this->command->info('Secretário: secretario@faspmpa.com.br / secretario123');
    }
}