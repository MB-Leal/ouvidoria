<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PerfisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desabilita a verificação de chaves estrangeiras
    Schema::disableForeignKeyConstraints();
    //apaga todos os registros da tabela
    DB::table('perfis')->truncate();
    // Insere os perfis iniciais

    DB::table('perfis')->insert([
        ['nome' => 'admin'],
        ['nome' => 'ouvidor'],
        ['nome' => 'secretario'],
    ]);

    // Habilita a verificação de chaves estrangeiras novamente
    Schema::enableForeignKeyConstraints();
    }
}
