<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Limpar cache de permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Criar permissões
        $permissions = [
            'visualizar_manifestacoes',
            'responder_manifestacoes',
            'atribuir_manifestacoes',
            'arquivar_manifestacoes',
            'gerar_relatorios',
            'gerenciar_usuarios',
            'configurar_sistema',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Criar roles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleOuvidor = Role::firstOrCreate(['name' => 'ouvidor']);
        $roleSecretario = Role::firstOrCreate(['name' => 'secretario']);

        // 3. Atribuir permissões aos roles
        $roleAdmin->syncPermissions(Permission::all());

        $roleOuvidor->syncPermissions([
            'visualizar_manifestacoes',
            'responder_manifestacoes',
            'atribuir_manifestacoes',
            'arquivar_manifestacoes',
            'gerar_relatorios',
        ]);

        $roleSecretario->syncPermissions([
            'visualizar_manifestacoes',
            'responder_manifestacoes',
        ]);

        // 4. Criar Usuários Administradores Específicos

        // Administrador: Marcos Leal
        $marcos = User::updateOrCreate(
            ['email' => 'marcosbleal26@gmail.com'],
            [
                'name' => 'Marcos Leal',
                'password' => Hash::make('Sdyj6rdx@'),
                'role' => 'admin',
                'ativo' => true,
            ]
        );
        $marcos->assignRole($roleAdmin);

        // Administrador: Adriano Maia
        $adriano = User::updateOrCreate(
            ['email' => 'drikomaia89@gmail.com'],
            [
                'name' => 'Adriano Maia',
                'password' => Hash::make('26157795'),
                'role' => 'admin',
                'ativo' => true,
            ]
        );
        $adriano->assignRole($roleAdmin);

        // 5. Criar usuários padrão para as outras funções (Opcional)

        $ouvidor = User::updateOrCreate(
            ['email' => 'ouvidor@faspmpa.com.br'],
            [
                'name' => 'Ouvidor Geral',
                'password' => Hash::make('ouvidor123'),
                'role' => 'ouvidor',
                'ativo' => true,
            ]
        );
        $ouvidor->assignRole($roleOuvidor);

        $secretario = User::updateOrCreate(
            ['email' => 'secretario@faspmpa.com.br'],
            [
                'name' => 'Secretário Auxiliar',
                'password' => Hash::make('secretario123'),
                'role' => 'secretario',
                'ativo' => true,
            ]
        );
        $secretario->assignRole($roleSecretario);

        $this->command->info('Roles e Administradores (Marcos e Adriano) criados com sucesso!');
    }
}