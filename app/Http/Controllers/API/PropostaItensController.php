<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proposta;
use App\Models\PropostaItens;
use Illuminate\Support\Facades\Auth;

class PropostaItensController extends Controller
{
  public function get(Request $request, $numeroProposta)
  {
    $pageSize = $request->page_size ? $request->page_size : 10;

    $proposta = Proposta::select('Num_prop', 'Repr')->where('Num_prop', $numeroProposta)->first();


    if (!$proposta) {
      return response()->json(['Proposta não encontrada'], 404);
    }

    if (Auth::user()->role === 'representante' && Auth::user()->role !== $proposta->Repr) {
      return response()->json(['Proposta não encontrada'], 404);
    }

    $itens = PropostaItens::where('Num_prop', $numeroProposta)->paginate($pageSize);

    return response()->json($itens);
  }
}