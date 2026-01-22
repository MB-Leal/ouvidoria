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
        $validated = $request->validate([
            'tipo_manifestacao_id' => 'required|exists:tipos_manifestacao,id',
            'canal' => 'required|in:PRESENCIAL,EMAIL,TELEFONE,WEB',
            'status' => 'required|in:ABERTO,EM_ANALISE,RESPONDIDO,FINALIZADO',
            'nome' => 'nullable|required_if:anonimo,false|string|max:255',
            'anonimo' => 'boolean',
            'email' => 'nullable|email',
            'telefone' => 'nullable|string|max:20',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string|min:10',
            'sigilo_dados' => 'boolean',
            'anexo' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'observacao_interna' => 'nullable|string',
            'data_entrada' => 'nullable|date',
            'data_registro_sistema' => 'nullable|date',
        ]);

        $protocolo = ProtocoloService::gerarProtocolo();

        $dadosManifestacao = [
    'protocolo' => $protocolo,
    'tipo_manifestacao_id' => $validated['tipo_manifestacao_id'],
    'canal' => $validated['canal'],
    'status' => $validated['status'],
    'assunto' => $validated['assunto'],
    'descricao' => $validated['descricao'],
    'sigilo_dados' => $request->boolean('sigilo_dados'),
    'prioridade' => $validated['prioridade'],
    'observacao_interna' => $validated['observacao_interna'] ?? null,
    'data_entrada' => $request->data_entrada ?? now(),
    'data_registro_sistema' => $request->data_registro_sistema ?? now(),
    'user_id' => auth()->id(), // Usamos user_id para registrar quem criou manualmente
];

        if ($request->boolean('anonimo')) {
            $dadosManifestacao['nome'] = $request->nome;
            $dadosManifestacao['email'] = $request->email;
            $dadosManifestacao['telefone'] = $request->telefone;
        } else {
            $dadosManifestacao['nome'] = $validated['nome'];
            $dadosManifestacao['email'] = $validated['email'] ?? null;
            $dadosManifestacao['telefone'] = $validated['telefone'] ?? null;
        }

        if ($validated['status'] == 'RESPONDIDO') {
            $dadosManifestacao['data_resposta'] = now();
        }

        DB::beginTransaction();
        try {
            $manifestacao = Manifestacao::create($dadosManifestacao);

            if ($request->hasFile('anexo')) {
                $path = $request->file('anexo')->store('anexos', 'public');
                $manifestacao->update(['anexo_path' => $path]);
            }

            DB::commit();

            return redirect()->route('admin.manifestacoes.show', $manifestacao)
                ->with('success', 'Protocolo: ' . $protocolo);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro: ' . $e->getMessage()]);
        }
    }
}