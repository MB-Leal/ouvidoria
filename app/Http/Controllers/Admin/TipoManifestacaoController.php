<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoManifestacao; // Certifique-se de que o Model está correto
use Illuminate\Http\Request;

class TipoManifestacaoController extends Controller
{
    /**
     * Exibe a lista de Tipos de Manifestação.
     * Corresponde à rota 'admin.tipos.index'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 🚨 Certifique-se de que o Model 'TipoManifestacao' existe e está configurado
        $tipos = TipoManifestacao::orderBy('nome')->paginate(10); 
        return view('admin.tipos.index', compact('tipos'));
    }

    /**
     * Mostra o formulário para criar um novo tipo.
     * Corresponde à rota 'admin.tipos.create'.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Pode ser útil enviar as cores disponíveis para o formulário (exemplo)
        // $available_colors = TipoManifestacao::getAvailableColors(); 
        return view('admin.tipos.create'); // , compact('available_colors')
    }

    // Você precisará implementar os métodos store, edit, update e destroy para o CRUD completo.
}