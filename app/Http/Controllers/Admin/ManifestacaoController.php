<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manifestacao;
use App\Models\User;
use Illuminate\Http\Request;

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
}