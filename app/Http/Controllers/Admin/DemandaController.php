<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demanda;
use App\Models\TipoDemanda;
use Illuminate\Http\Request;

class DemandaController extends Controller
{
    // Listar todas as demandas com filtros
    public function index(Request $request)
    {
        $demandas = Demanda::with('tipo')->latest()->paginate(15);
        $tipos = TipoDemanda::all();

        return view('admin.demandas.index', compact('demandas', 'tipos'));
    }
    //exibir os detalhes da demanda
    public function show(Demanda $demanda)
    {
        // O Laravel já encontra a demanda pelo ID. Agora carregamos os pareceres
        $demanda->load('pareceres.usuario');

        return view('admin.demandas.show', compact('demanda'));
    }
    // Salvar o novo parecer para a demanda e atualizar seu status
    public function storeParecer(Request $request, Demanda $demanda)
    {
        // 1. Validação
        $request->validate([
            'parecer' => 'required|string|min:10',
        ]);

        // 2. Cria o novo parecer no banco de dados
        $parecer = new Parecer();
        $parecer->demanda_id = $demanda->id;
        $parecer->usuario_id = Auth::id(); // Pega o ID do usuário autenticado
        $parecer->parecer = $request->parecer;
        $parecer->save();

        // 3. Atualiza o status da demanda
        // Se o status atual for 'Recebido', atualiza para 'Em Andamento'
        if ($demanda->status == 'Recebido') {
            $demanda->status = 'Em Andamento';
            $demanda->save();
        }

        // 4. Redireciona de volta para a página de detalhes da demanda
        return redirect()->route('admin.demandas.show', $demanda)->with('success', 'Parecer adicionado com sucesso!');
    }
}