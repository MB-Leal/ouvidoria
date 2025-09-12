<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    // Listar todos os usuários
    public function index()
    {
        $usuarios = User::with('perfis')->latest()->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Exibir o formulário de criação
    public function create()
    {
        $perfis = Perfil::all();
        return view('admin.usuarios.create', compact('perfis'));
    }

    // Salvar um novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'perfil_id' => 'required|exists:perfis,id',
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Associa o perfil ao usuário
        $usuario->perfis()->attach($request->perfil_id);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    // Exibir o formulário de edição
    public function edit(User $usuario)
    {
        $perfis = Perfil::all();
        return view('admin.usuarios.edit', compact('usuario', 'perfis'));
    }

    // Atualizar um usuário
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios')->ignore($usuario->id)],
            'perfil_id' => 'required|exists:perfis,id',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sincroniza o perfil do usuário (desanexa o antigo e anexa o novo)
        $usuario->perfis()->sync([$request->perfil_id]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Excluir um usuário
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
