<?php

namespace App\Http\Controllers;

use App\Models\Demanda;
use App\Models\TipoDemanda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DemandaController extends Controller
{
    // Método para exibir o formulário de registro com base no tipo
    public function create($tipo)
    {
        // Busca o objeto TipoDemanda no banco de dados
        $tipoDemanda = TipoDemanda::where('slug', $tipo)->firstOrFail();
        return view('demandas.create', ['tipo' => $tipoDemanda]);
    }

    // Método para processar o formulário
    public function store(Request $request)
    {
        $request->validate([
            'tipo_id' => 'required|exists:tipos_demanda,id', // Validação do ID do tipo
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);

        $demanda = new Demanda;
        $demanda->tipo_id = $request->tipo_id; // Armazena o ID do tipo
        $demanda->nome = $request->nome;
        $demanda->email = $request->email;
        $demanda->assunto = $request->assunto;
        $demanda->mensagem = $request->mensagem;
        $demanda->status = 'Recebido';
        $demanda->protocolo = (string) Str::uuid();
        $demanda->save();

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
            return back()->withErrors(['message' => 'Demanda não encontrada. Verifique o protocolo e e-mail.']);
        }
        
        return view('demandas.show', ['demanda' => $demanda]);
    }
}