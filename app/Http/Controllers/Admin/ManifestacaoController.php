<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manifestacao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ProtocoloService;
use Illuminate\Support\Facades\DB;

class ManifestacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Manifestacao::with(['tipo', 'responsavel'])->latest();

        // Filtros mantidos para busca, mas sem restrição de visibilidade por usuário
        if ($request->filled('protocolo')) {
            $query->where('protocolo', 'like', '%' . $request->protocolo . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        if ($request->filled('responsavel')) {
            $query->where('user_id', $request->responsavel);
        }

        // REMOVIDO: O bloco que restringia a visualização para não-admins

        $manifestacoes = $query->paginate(20);
        $responsaveis = User::where('ativo', true)->get();

        $statuses = [
            'ABERTO' => 'Aberto',
            'EM_ANALISE' => 'Em Análise',
            'RESPONDIDO' => 'Respondido',
            'FINALIZADO' => 'Finalizado'
        ];

        $prioridades = [
            'baixa' => 'Baixa',
            'media' => 'Média',
            'alta' => 'Alta',
            'urgente' => 'Urgente'
        ];

        return view('admin.manifestacoes.index', compact(
            'manifestacoes',
            'responsaveis',
            'statuses',
            'prioridades'
        ));
    }

    public function show(Manifestacao $manifestacao)
    {
        // REMOVIDO: Verificação de permissão. Todos podem visualizar.
        $manifestacao->load(['tipo', 'responsavel']);
        return view('admin.manifestacoes.show', compact('manifestacao'));
    }

    public function edit(Manifestacao $manifestacao)
    {
        // REMOVIDO: Bloqueio de edição por usuário ou status. 
        // A equipe agora tem autonomia total para correções.

        $manifestacao->load(['tipo', 'responsavel']);
        $responsaveis = User::where('ativo', true)->get();

        $statuses = [
            'ABERTO' => 'Aberto',
            'EM_ANALISE' => 'Em Análise',
            'RESPONDIDO' => 'Respondido',
            'FINALIZADO' => 'Finalizado'
        ];

        $prioridades = [
            'baixa' => 'Baixa',
            'media' => 'Média',
            'alta' => 'Alta',
            'urgente' => 'Urgente'
        ];

        return view('admin.manifestacoes.edit', compact(
            'manifestacao',
            'responsaveis',
            'statuses',
            'prioridades'
        ));
    }

    public function update(Request $request, Manifestacao $manifestacao)
    {
        $validated = $request->validate([
            'status' => 'required|in:ABERTO,EM_ANALISE,RESPONDIDO,FINALIZADO',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'user_id' => 'nullable|exists:users,id',
            'resposta' => 'nullable|string',
            'observacao_interna' => 'nullable|string',
            'setor_responsavel' => 'nullable|string',
            'data_limite_resposta' => 'nullable|date',
            'data_resposta' => 'nullable|date',
        ]);

        // Registrar quem está atualizando (Rastreabilidade)
        $validated['updated_by'] = auth()->id();

        if ($validated['status'] == 'RESPONDIDO' && $manifestacao->status != 'RESPONDIDO') {
            $validated['data_resposta'] = now();
        }

        $manifestacao->update($validated);

        return redirect()->route('admin.manifestacoes.show', $manifestacao)
            ->with('success', 'Manifestação atualizada com sucesso!');
    }

    public function atribuir(Request $request, Manifestacao $manifestacao)
    {
        // Embora você queira eliminar a obrigatoriedade, mantive a função 
        // caso queiram designar um "ponto focal" no formulário sem travar o acesso.
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $manifestacao->update([
            'user_id' => $request->user_id,
            'updated_by' => auth()->id()
        ]);

        return back()->with('success', 'Responsável definido com sucesso!');
    }

    public function arquivar(Request $request, Manifestacao $manifestacao)
    {
        $request->validate([
            'motivo_arquivamento' => 'required|string',
        ]);

        $manifestacao->update([
            'arquivado_em' => now(),
            'archived_by' => auth()->id(), // Registra quem arquivou
            'motivo_arquivamento' => $request->motivo_arquivamento,
            'status' => 'FINALIZADO',
            'updated_by' => auth()->id()
        ]);

        return back()->with('success', 'Manifestação arquivada com sucesso!');
    }

    public function createManual()
    {
        $tipos = \App\Models\TipoManifestacao::where('ativo', true)->get();
        $statuses = [
            'ABERTO' => 'Aberto',
            'EM_ANALISE' => 'Em Análise',
            'RESPONDIDO' => 'Respondido',
            'FINALIZADO' => 'Finalizado'
        ];
        $canais = [
            'PRESENCIAL' => 'Presencial',
            'EMAIL' => 'E-mail',
            'TELEFONE' => 'Telefone/WhatsApp',
            'WEB' => 'Formulário Web'
        ];

        return view('admin.manifestacoes.create-manual', compact('tipos', 'statuses', 'canais'));
    }

    public function storeManual(Request $request)
    {
        $isAnonymous = $request->has('anonimo');

        $rules = [
            'tipo_manifestacao_id' => 'required|exists:tipos_manifestacao,id',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string|min:10',
            'canal' => 'required|string',
            'status' => 'required|string',
            'prioridade' => 'required|string',
            'data_entrada' => 'required|date',
        ];

        if (!$isAnonymous) {
            $rules['nome'] = 'required|string|max:255';
            $rules['email'] = 'nullable|email'; // No admin o email pode ser opcional se o cara não tiver
        }

        $validated = $request->validate($rules);

        // Geração de Protocolo e Token
        $protocolo = \App\Services\ProtocoloService::gerarProtocolo();
        $chaveAleatoria = strtoupper(\Illuminate\Support\Str::random(7));
        $tokenHash = \Illuminate\Support\Facades\Hash::make($chaveAleatoria);

        $dados = [
            'protocolo' => $protocolo,
            'token' => $tokenHash,
            'tipo_manifestacao_id' => $validated['tipo_manifestacao_id'],
            'assunto' => $validated['assunto'],
            'descricao' => $validated['descricao'],
            'canal' => $validated['canal'],
            'status' => $validated['status'],
            'prioridade' => $validated['prioridade'],
            'data_entrada' => $validated['data_entrada'],
            'data_registro_sistema' => now(),
            'sigilo_dados' => $request->has('sigilo_dados'),
            'observacao_interna' => $request->observacao_interna,
            'user_id' => auth()->id(), // Ouvidor que cadastrou
        ];

        if ($isAnonymous) {
            $dados['nome'] = 'Anônimo';
            $dados['email'] = null;
        } else {
            $dados['nome'] = $validated['nome'];
            $dados['email'] = $validated['email'] ?? null;
            $dados['telefone'] = $request->telefone;
        }

        $manifestacao = Manifestacao::create($dados);

        // Processar anexo (mantido)
        if ($request->hasFile('anexo')) {
            $path = $request->file('anexo')->store('anexos', 'public');
            $manifestacao->update(['anexo_path' => $path]);
        }

        // Redireciona de volta com os dados para o Modal
        return back()->with([
            'success_manual' => true,
            'protocolo' => $protocolo,
            'chave_acesso' => $chaveAleatoria,
            'email_manifestante' => $manifestacao->email,
            'manifestacao_id' => $manifestacao->id
        ]);
    }

    /**
     * Rota para disparar e-mail manualmente a partir do modal
     */
    public function notificarManual(Request $request, Manifestacao $manifestacao)
    {
        // O token (chave) vem do campo oculto no modal
        $chave = $request->input('chave');

        if ($manifestacao->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($manifestacao->email)
                    ->send(new \App\Mail\ManifestacaoRecebida($manifestacao, $chave));

                return back()->with('success', 'Notificação enviada com sucesso para ' . $manifestacao->email);
            } catch (\Exception $e) {
                return back()->with('error', 'Falha ao enviar e-mail: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Manifestante não possui e-mail cadastrado.');
    }


    public function finalizar(Manifestacao $manifestacao)
    {
        $manifestacao->update(['status' => 'FINALIZADO']);

        // Apenas chama a função e ela faz o resto
        $this->notificarManifestante($manifestacao, null, "Sua manifestação foi FINALIZADA!");

        return back()->with('success', 'Manifestação encerrada e cidadão notificado.');
    }
}
