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
        $user = auth()->user();
        $query = Manifestacao::with(['tipo', 'responsavel'])->latest();

        // Filtros
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

        // Se não for admin, mostrar apenas atribuídas ou sem responsável
        if (!$user->isAdmin()) {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereNull('user_id');
            });
        }

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
        $user = auth()->user();
        
        // Verificar permissão
        if (!$user->isAdmin() && $manifestacao->user_id && $manifestacao->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado');
        }
        
        $manifestacao->load(['tipo', 'responsavel']);
        return view('admin.manifestacoes.show', compact('manifestacao'));
    }

    public function edit(Manifestacao $manifestacao)
    {
        $user = auth()->user();
        
        // Verificar permissão para editar
        if (!$user->isAdmin() && 
            ($manifestacao->user_id !== $user->id || 
             ($user->isSecretario() && $manifestacao->status === 'RESPONDIDO'))) {
            abort(403, 'Acesso não autorizado');
        }
        
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
        $user = auth()->user();
        
        // Verificar permissão para editar
        if (!$user->isAdmin() && 
            ($manifestacao->user_id !== $user->id || 
             ($user->isSecretario() && $manifestacao->status === 'RESPONDIDO'))) {
            abort(403, 'Acesso não autorizado');
        }

        $validated = $request->validate([
            'status' => 'required|in:ABERTO,EM_ANALISE,RESPONDIDO,FINALIZADO',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'user_id' => 'nullable|exists:users,id',
            'resposta' => 'nullable|string',
            'observacao_interna' => 'nullable|string',
            'setor_responsavel' => 'nullable|string',
            'data_limite_resposta' => 'nullable|date',
        ]);

        // Se está respondendo, registrar data
        if ($validated['status'] == 'RESPONDIDO' && $manifestacao->status != 'RESPONDIDO') {
            $validated['respondido_em'] = now();
        }

        $manifestacao->update($validated);

        return redirect()->route('admin.manifestacoes.show', $manifestacao)
            ->with('success', 'Manifestação atualizada com sucesso!');
    }

    public function atribuir(Request $request, Manifestacao $manifestacao)
    {
        $user = auth()->user();
        
        // Apenas admin e ouvidor podem atribuir
        if (!$user->isAdmin() && !$user->isOuvidor()) {
            abort(403, 'Acesso não autorizado');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $manifestacao->update(['user_id' => $request->user_id]);

        return back()->with('success', 'Manifestação atribuída com sucesso!');
    }

    public function arquivar(Request $request, Manifestacao $manifestacao)
    {
        $user = auth()->user();
        
        // Apenas admin e ouvidor podem arquivar
        if (!$user->isAdmin() && !$user->isOuvidor()) {
            abort(403, 'Acesso não autorizado');
        }

        $request->validate([
            'motivo_arquivamento' => 'required|string',
        ]);

        $manifestacao->update([
            'arquivado_em' => now(),
            'motivo_arquivamento' => $request->motivo_arquivamento,
            'status' => 'FINALIZADO'
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

/**
 * Salva uma manifestação cadastrada manualmente
 */
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
        'descricao' => 'required|string|min:10',
        'anexo' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx',
        'prioridade' => 'required|in:baixa,media,alta,urgente',
        'observacao_interna' => 'nullable|string',
    ]);

    // Gerar protocolo
    $protocolo = ProtocoloService::gerarProtocolo();

    // Preparar dados
    $dadosManifestacao = [
        'protocolo' => $protocolo,
        'tipo_manifestacao_id' => $validated['tipo_manifestacao_id'],
        'canal' => $validated['canal'],
        'status' => $validated['status'],
        'descricao' => $validated['descricao'],
        'prioridade' => $validated['prioridade'],
        'observacao_interna' => $validated['observacao_interna'] ?? null,
    ];

    // Se for anônimo
    if ($request->boolean('anonimo')) {
        $dadosManifestacao['nome'] = 'Anônimo';
        $dadosManifestacao['email'] = null;
        $dadosManifestacao['telefone'] = null;
    } else {
        $dadosManifestacao['nome'] = $validated['nome'];
        $dadosManifestacao['email'] = $validated['email'] ?? null;
        $dadosManifestacao['telefone'] = $validated['telefone'] ?? null;
    }

    // Se já for respondido, registrar data
    if ($validated['status'] == 'RESPONDIDO') {
        $dadosManifestacao['respondido_em'] = now();
        $dadosManifestacao['data_resposta'] = now();
    }

    // Atribuir ao usuário logado se for ouvidor/secretário
    $user = auth()->user();
    if (in_array($user->role, ['ouvidor', 'secretario'])) {
        $dadosManifestacao['user_id'] = $user->id;
    }

    DB::beginTransaction();
    
    try {
        $manifestacao = Manifestacao::create($dadosManifestacao);

        // Processar anexo
        if ($request->hasFile('anexo')) {
            $path = $request->file('anexo')->store('anexos', 'public');
            $manifestacao->update(['anexo_path' => $path]);
        }

        DB::commit();

        return redirect()->route('admin.manifestacoes.show', $manifestacao)
            ->with('success', 'Manifestação cadastrada manualmente com sucesso! Protocolo: ' . $protocolo);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Erro ao cadastrar manifestação: ' . $e->getMessage()]);
    }
}
}