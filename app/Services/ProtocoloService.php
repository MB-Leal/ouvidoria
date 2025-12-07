<?php

namespace App\Services;

use App\Models\Manifestacao;
use Illuminate\Support\Facades\DB;

class ProtocoloService {
    public static function gerarProtocolo(): string {
        $ano = date('Y');
        $prefixo = 'FASPM';
        
        DB::beginTransaction();
        
        try {
            // Usar lock para evitar duplicatas
            $ultima = Manifestacao::lockForUpdate()
                ->where('protocolo', 'like', "{$prefixo}-{$ano}-%")
                ->orderBy('protocolo', 'desc')
                ->first();
            
            if ($ultima && preg_match("/{$prefixo}-{$ano}-(\d{6})/", $ultima->protocolo, $matches)) {
                $numero = (int)$matches[1] + 1;
            } else {
                $numero = 1;
            }
            
            $protocolo = sprintf('%s-%s-%06d', $prefixo, $ano, $numero);
            
            DB::commit();
            
            return $protocolo;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}