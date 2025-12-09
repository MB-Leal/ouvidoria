<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoManifestacao;
use Illuminate\Http\Request;

class TipoManifestacaoController extends Controller
{
    /**
     * Exibe a lista de Tipos de Manifestação.
     * Corresponde à rota 'admin.tipos.index'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tipos = TipoManifestacao::orderBy('nome')->paginate(10); 
        return view('admin.tipos.index', compact('tipos'));
    }

    /**
     * Mostra o formulário para criar um novo tipo.
     * Corresponde à rota 'admin.tipos.create'.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tipos.create');
    }

    /**
     * Salva um novo tipo de manifestação.
     * Corresponde à rota 'admin.tipos.store'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:191|unique:tipos_manifestacao,nome',
            'cor' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'prazo_dias' => 'required|integer|min:1|max:365',
            'ativo' => 'boolean',
        ]);

        // Garantir que a cor comece com #
        if (!str_starts_with($validated['cor'], '#')) {
            $validated['cor'] = '#' . $validated['cor'];
        }
        
        // Converter para maiúsculas
        $validated['cor'] = strtoupper($validated['cor']);

        TipoManifestacao::create([
            'nome' => $validated['nome'],
            'cor' => $validated['cor'],
            'prazo_dias' => $validated['prazo_dias'],
            'ativo' => $request->boolean('ativo'),
        ]);

        return redirect()->route('admin.tipos.index')
            ->with('success', 'Tipo de manifestação criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um tipo.
     * Corresponde à rota 'admin.tipos.edit'.
     *
     * @param  \App\Models\TipoManifestacao  $tipo
     * @return \Illuminate\View\View
     */
    public function edit(TipoManifestacao $tipo)
    {
        return view('admin.tipos.edit', compact('tipo'));
    }

    /**
     * Atualiza um tipo de manifestação.
     * Corresponde à rota 'admin.tipos.update'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoManifestacao  $tipo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TipoManifestacao $tipo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:191|unique:tipos_manifestacao,nome,' . $tipo->id,
            'cor' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'prazo_dias' => 'required|integer|min:1|max:365',
            'ativo' => 'boolean',
        ]);

        // Garantir que a cor comece com #
        if (!str_starts_with($validated['cor'], '#')) {
            $validated['cor'] = '#' . $validated['cor'];
        }
        
        // Converter para maiúsculas
        $validated['cor'] = strtoupper($validated['cor']);

        $tipo->update([
            'nome' => $validated['nome'],
            'cor' => $validated['cor'],
            'prazo_dias' => $validated['prazo_dias'],
            'ativo' => $request->boolean('ativo'),
        ]);

        return redirect()->route('admin.tipos.index')
            ->with('success', 'Tipo de manifestação atualizado com sucesso!');
    }

    /**
     * Remove um tipo de manifestação.
     * Corresponde à rota 'admin.tipos.destroy'.
     *
     * @param  \App\Models\TipoManifestacao  $tipo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TipoManifestacao $tipo)
    {
        // Verificar se existem manifestações usando este tipo
        if ($tipo->manifestacoes()->exists()) {
            return redirect()->route('admin.tipos.index')
                ->with('error', 'Não é possível excluir este tipo pois existem manifestações vinculadas a ele.');
        }

        $tipo->delete();

        return redirect()->route('admin.tipos.index')
            ->with('success', 'Tipo de manifestação excluído com sucesso!');
    }
}