<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function index()
    {
        // Contagem de demandas por status para o dashboard
        $contagem_status = Demanda::select('status', \DB::raw('count(*) as total'))
                                    ->groupBy('status')
                                    ->get();

        // Demanda mais recente
        $ultimaDemanda = Demanda::latest()->first();

        return view('admin.dashboard', compact('contagem_status', 'ultimaDemanda'));
    }
}
