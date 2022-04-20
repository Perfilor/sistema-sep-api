<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proposta;

class ClienteCobrancaController extends Controller
{
  public function getById($id)
  {
    $proposta = Proposta::select('RazaoSocialC', 'CNPJCobranca', 'End_Cobranca', 'Cidade_Cobranca', 'Cidade_Cobranca', 'CEP_Cobranca', 'Telefone_Cobranca', 'Bairro_Cobranca', 'Responsavel_Ent', 'IE_E', 'Uf')->where('Num_prop', $id)->first();

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
        'RazaoSocialC' => $request->RazaoSocialC,
        'CNPJCobranca' => $request->CNPJCobranca,
        'End_Cobranca' => $request->End_Cobranca,
        'Cidade_Cobranca' => $request->Cidade_Cobranca,
        'CEP_Cobranca' => $request->CEP_Cobranca,
        'Telefone_Cobranca' => $request->Telefone_Cobranca,
        'Bairro_Cobranca' => $request->Bairro_Cobranca,
        'Email_Cobranca' => $request->Email_Cobranca
      ]);

      return response()->json(['message' => 'Dados atualizados com sucesso', 'data' => $proposta], 200);
    } catch (\Exception $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente'], 500);
    }
  }
}