<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuscaController extends Controller
{
    public function index(Request $request)
    {
        $termoBusca = $request->input('q');

        // Aqui você adicionará a lógica de busca no seu banco de dados
        // Exemplo:
        // $resultados = Demanda::where('assunto', 'like', "%{$termoBusca}%")
        //     ->orWhere('mensagem', 'like', "%{$termoBusca}%")
        //     ->get();

        return view('resultados-busca', ['resultados' => $resultados ?? [], 'termo' => $termoBusca]);
    }
}
