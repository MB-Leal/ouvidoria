<?php

namespace App\Http\Controllers;

use App\Models\Manifestacao;
use App\Models\TipoManifestacao;
use App\Services\ProtocoloService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ManifestacaoController extends Controller
{
    // Página inicial com formulário
    public function create()
    {
        $tipos = TipoManifestacao::where('ativo', true)->get();
        return view('manifestacoes.create', compact('tipos'));
    }

    // Salvar nova manifestação
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_manifestacao_id' => 'required|exists:tipos_manifestacao,id',
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'nullable|string',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string|min:10',
            'sigilo_dados' => 'boolean',
            'anexo' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx',
        ]);

        // Gerar protocolo
        $protocolo = ProtocoloService::gerarProtocolo();

        // Salvar manifestação
        $manifestacao = Manifestacao::create([
            'protocolo' => $protocolo,
            'tipo_manifestacao_id' => $validated['tipo_manifestacao_id'],
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'assunto' => $validated['assunto'],
            'descricao' => $validated['descricao'],
            'sigilo_dados' => $request->boolean('sigilo_dados'),
            'status' => 'ABERTO',
            'canal' => 'WEB'
        ]);

        // Processar anexo
        if ($request->hasFile('anexo')) {
            $path = $request->file('anexo')->store('anexos', 'public');
            $manifestacao->update(['anexo_path' => $path]);
        }

        // Tentar enviar email de confirmação
        try {
            // Verificar se a classe do email existe
            if (class_exists('App\Mail\ManifestacaoRecebida')) {
                Mail::to($manifestacao->email)->send(new \App\Mail\ManifestacaoRecebida($manifestacao));
            }
        } catch (\Exception $e) {
            // Log do erro, mas continua o processo
            \Log::error('Erro ao enviar email: ' . $e->getMessage());
        }

        return redirect()->route('manifestacoes.show', $manifestacao)
            ->with('success', 'Manifestação registrada com sucesso!');
    }

    // Mostrar manifestação (público)
    public function show(Manifestacao $manifestacao)
    {
        $manifestacao->load('tipo');
        return view('manifestacoes.show', compact('manifestacao'));
    }

    // Página de acompanhamento
    public function acompanhar()
    {
        return view('manifestacoes.acompanhar');
    }

    // Buscar manifestação por protocolo
    public function buscar(Request $request)
    {
        $request->validate([
            'protocolo' => 'required|string'
        ]);

        $manifestacao = Manifestacao::where('protocolo', $request->protocolo)->first();

        if (!$manifestacao) {
            return back()->withErrors(['protocolo' => 'Protocolo não encontrado!']);
        }

        return view('manifestacoes.show', compact('manifestacao'));
    }
}
