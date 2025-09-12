<?php

namespace App\Http\Controllers;

use App\Models\Demanda;
use App\Models\TipoDemanda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\DemandaRegistrada;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\StoreDemandaRequest;
use Illuminate\Support\Facades\DB;

class DemandaController extends Controller
{
    // Método para exibir a página de seleção do tipo de demanda
    public function index()
    {
        $tipos = TipoDemanda::all();
        // A visualização é 'demandas.index', que é pública.
        return view('demandas.index', compact('tipos'));
    }

    // Método para exibir o formulário de registro
    public function create(TipoDemanda $tipo)
    {
        return view('demandas.create', compact('tipo'));
    }

    // Método para salvar a nova demanda no banco de dados
    public function store(StoreDemandaRequest $request)
    {
        $demanda = new Demanda();
        $demanda->nome = $request->nome;
        $demanda->email = $request->email;
        $demanda->telefone = $request->telefone;
        $demanda->tipo_id = $request->tipo_id;
        $demanda->mensagem = $request->mensagem;
        $demanda->status = 'Recebido';
        $demanda->protocolo = (string) Str::uuid();
        $demanda->save();

        if ($demanda->email) {
            Notification::route('mail', $demanda->email)->notify(new DemandaRegistrada($demanda));
        }

        return redirect()->route('demanda.sucesso')->with('protocolo', $demanda->protocolo)->with('email', $demanda->email);
    }

    // Método para exibir o formulário de consulta
    public function showConsultaForm()
    {
        return view('demandas.consultar');
    }

    // Método para buscar e exibir a demanda
    public function showDemanda(Request $request)
    {
        $request->validate([
            'protocolo' => 'required|string|max:50',
            'email' => 'required|email|max:255',
        ]);

        $demanda = Demanda::where('protocolo', $request->protocolo)
                          ->where('email', $request->email)
                          ->with('tipo', 'pareceres')
                          ->first();

        if (!$demanda) {
            return redirect()->route('demanda.consultar')->with('status', 'Protocolo ou e-mail inválidos. Por favor, verifique e tente novamente.');
        }

        return view('demandas.detalhes_consulta', compact('demanda'));
    }

    // Método para exibir relatórios públicos
    public function relatoriosPublicos()
    {
        $totalDemandas = Demanda::count();
        $demandasSolucionadas = Demanda::where('status', 'Solucionado')->count();

        $elogios = Demanda::whereHas('tipo', function ($query) {
            $query->where('nome', 'Elogio');
        })
        ->inRandomOrder()
        ->limit(3)
        ->get();
        
        return view('demandas.relatorios', compact('totalDemandas', 'demandasSolucionadas', 'elogios'));
    }
}