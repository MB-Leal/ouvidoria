<?php

namespace App\Http\Controllers;

use App\Models\Manifestacao;
use App\Models\TipoManifestacao;
use App\Services\ProtocoloService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManifestacaoController extends Controller
{
    /**
     * Exibe o formulário de criação de nova manifestação.
     */
    public function create()
    {
        $tipos = TipoManifestacao::where('ativo', true)->get();
        return view('manifestacoes.create', compact('tipos'));
    }

    /**
     * Processa e salva a nova manifestação.
     */
    public function store(Request $request)
    {
        // 1. Identifica se a manifestação é anônima
        $isAnonymous = $request->has('is_anonymous');

        // 2. Regras de Validação
        $rules = [
            'tipo_manifestacao_id' => 'required|exists:tipos_manifestacao,id',
            'assunto'              => 'required|string|max:255',
            'descricao'            => 'required|string|min:10',
            'sigilo_dados'         => 'boolean',
            'anexo'                => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx',
        ];

        // Se NÃO for anônima, exige e-mail para LGPD
        if (!$isAnonymous) {
            $rules['email']    = 'required|email';
            $rules['nome']     = 'nullable|string|max:255';
            $rules['telefone'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // 3. Geração de Protocolo e Token de Segurança
        $protocolo      = ProtocoloService::gerarProtocolo();
        $chaveAleatoria = strtoupper(Str::random(7)); // Chave que o cidadão visualizará
        $tokenParaBanco = Hash::make($chaveAleatoria); // Hash seguro para o banco

        // 4. Preparação dos dados (Respeitando a LGPD e anonimato)
        $dados = [
            'protocolo'            => $protocolo,
            'token'                => $tokenParaBanco,
            'tipo_manifestacao_id' => $validated['tipo_manifestacao_id'],
            'assunto'              => $validated['assunto'],
            'descricao'            => $validated['descricao'],
            'sigilo_dados'         => $isAnonymous ? true : $request->boolean('sigilo_dados'),
            'status'               => 'ABERTO',
            'data_entrada'         => now(),
            'canal'                => 'WEB'
        ];

        if ($isAnonymous) {
            $dados['nome']     = 'Anônimo';
            $dados['email']    = null;
            $dados['telefone'] = null;
        } else {
            $dados['nome']     = $validated['nome'] ?? null;
            $dados['email']    = $validated['email'];
            $dados['telefone'] = $validated['telefone'] ?? null;
        }

        $manifestacao = Manifestacao::create($dados);

        // 5. Processamento de Anexo
        if ($request->hasFile('anexo')) {
            $path = $request->file('anexo')->store('anexos', 'public');
            $manifestacao->update(['anexo_path' => $path]);
        }

        // 6. Notificação via E-mail (Apenas para identificados)
        if (!$isAnonymous && !empty($manifestacao->email)) {
            $this->notificarManifestante($manifestacao, $chaveAleatoria);
        }

        // 7. Redirecionamento com a Chave na Sessão (Flash Data)
        return redirect()->route('manifestacoes.show', $manifestacao->id)
            ->with('success', 'Manifestação registrada com sucesso!')
            ->with('chave_acesso', $chaveAleatoria);
    }

    /**
     * Exibe os detalhes de uma manifestação específica.
     */
    public function show(Manifestacao $manifestacao)
    {
        $manifestacao->load('tipo');
        return view('manifestacoes.show', compact('manifestacao'));
    }

    /**
     * Exibe a página de acompanhamento (busca).
     */
    public function acompanhar()
    {
        return view('manifestacoes.acompanhar');
    }

    /**
     * Busca a manifestação validando Protocolo + Chave (Hash).
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'protocolo' => 'required|string',
            'chave'     => 'required|string'
        ]);

        // Busca pelo protocolo
        $manifestacao = Manifestacao::where('protocolo', $request->protocolo)->first();

        // VALIDAÇÃO DE SEGURANÇA:
        // 1. Verifica se a manifestação existe
        // 2. Verifica se a coluna 'token' não está nula no banco
        // 3. Verifica se a chave digitada bate com o Hash (Bcrypt) salvo
        if ($manifestacao && !empty($manifestacao->token) && Hash::check(strtoupper($request->chave), $manifestacao->token)) {
            return view('manifestacoes.show', compact('manifestacao'));
        }

        // Se houver qualquer falha, retorna erro genérico
        return back()
            ->withInput()
            ->withErrors(['protocolo' => 'Dados de acesso incorretos. Verifique o protocolo e a chave.']);
    }

    /**
     * Função auxiliar para envio de e-mails de notificação.
     */
    private function notificarManifestante(Manifestacao $manifestacao, $chave = null, $mensagemAssunto = null)
    {
        if (empty($manifestacao->email) || $manifestacao->nome === 'Anônimo') {
            return false;
        }

        try {
            Mail::to($manifestacao->email)->send(new \App\Mail\ManifestacaoRecebida($manifestacao, $chave, $mensagemAssunto));
            return true;
        } catch (\Exception $e) {
            Log::error("Falha ao enviar e-mail para o protocolo {$manifestacao->protocolo}: " . $e->getMessage());
            return false;
        }
    }
}
