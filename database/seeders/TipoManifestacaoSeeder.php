<?php

namespace Database\Seeders;

use App\Models\TipoManifestacao;
use Illuminate\Database\Seeder;

class TipoManifestacaoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nome' => 'Reclamação', 'cor' => '#dc3545', 'prazo_dias' => 30, 'ativo' => true],
            ['nome' => 'Elogio', 'cor' => '#28a745', 'prazo_dias' => 15, 'ativo' => true],
            ['nome' => 'Sugestão', 'cor' => '#17a2b8', 'prazo_dias' => 20, 'ativo' => true],
            ['nome' => 'Denúncia', 'cor' => '#ffc107', 'prazo_dias' => 30, 'ativo' => true],
            ['nome' => 'Solicitação de Informação', 'cor' => '#6f42c1', 'prazo_dias' => 20, 'ativo' => true],
            ['nome' => 'Outros', 'cor' => '#a3b18a', 'prazo_dias' => 30, 'ativo' => true],          
        ];

        foreach ($tipos as $tipo) {
            TipoManifestacao::create($tipo);
        }
    }
}