<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proposta;

class ClienteEntregaController extends Controller
{
  public function getById($id)
  {
    $proposta = Proposta::select('CNPJEntrega', 'End_Entrega', 'Cidade_Entrega', 'Cidade_Entrega', 'CEP_Entrega', 'Telefone_Entrega', 'Bairro_Entrega', 'Responsavel_Ent', 'IE_E', 'Uf')->where('Num_prop', $id)->first();

    if (!$proposta) {
      return response()->json(['message' => 'Proposta não encontrada'], 404);
    }

    return response()->json($proposta);
  }

  public function update(Request $request, $id)
  {
    $proposta = Proposta::select('Num_prop')->where('Num_prop', $id)->first();

    if (!$proposta) {
      return response()->json(['message' => 'Proposta não encontrada'], 404);
    }

    try {
      $proposta = Proposta::where('Num_prop', $id)->update([
        'RazaosocialE' => $request->RazaosocialE,
        'CNPJEntrega' => $request->CNPJEntrega,
        'End_Entrega' => $request->End_Entrega,
        'Cidade_Entrega' => $request->Cidade_Entrega,
        'CEP_Entrega' => $request->CEP_Entrega,
        'Telefone_Entrega' => $request->Telefone_Entrega,
        'Bairro_Entrega' => $request->Bairro_Entrega,
        'Responsavel_Ent' => $request->Responsavel_Ent,
        'IE_E' => $request->IE_E,
        'Uf' => $request->Uf,
      ]);

      return response()->json(['message' => 'Dados atualizados com sucesso', 'data' => $proposta], 200);
    } catch (\Exception $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente'], 500);
    }
  }
}