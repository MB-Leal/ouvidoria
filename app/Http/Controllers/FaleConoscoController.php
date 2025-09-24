<?php

namespace App\Http\Controllers;

use App\Models\FaleConosco;
use Illuminate\Http\Request;

class FaleConoscoController extends Controller
{
    public function create()
    {
        return view('fale-conosco');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);

        FaleConosco::create($request->all());

        return back()->with('success', 'Sua mensagem foi enviada com sucesso!');
    }
}
