<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\ClientesContato;

class ClientesContatoController extends Controller
{
  public function getById($id)
  {
    $cliente = Clientes::find($id);

    if (!$cliente) {
      return response()->json(['message' => 'Cliente não encontrado'], 404);
    }

    $contato = ClientesContato::select('Bairro', 'CEP', 'Celular', 'Cidade', 'Contato_Emp', 'Email', 'Endereco', 'Nome', 'Telefone', 'UF')->where('Codigo_cliente', $id)->first();

    return response()->json($contato);
  }

  public function store(Request $request, $id)
  {
    $cliente = Clientes::find($id);

    if (!$cliente) {
      return response()->json(['message' => 'Cliente não encontrado'], 404);
    }

    try {
      $contato = ClientesContato::create([
        'Codigo_cliente' => $id,
        'Nome' => $request->empresa,
        'Contato_Emp' => $request->responsavel,
        'Telefone' => $request->fone_cont,
        'Celular' => $request->cel_cont,
        'Endereco' => $request->end_cont,
        'Bairro' => $request->bairro_cont,
        'Cidade' => strtoupper($request->cidade_cont),
        'UF' => strtoupper($request->uf),
        'Email' => $request->email_nfe,
        'CEP' => $request->cep_cont
      ]);

      return response()->json(['message' => 'Cliente cadastrado com sucesso', 'data' => $contato], 203);
    } catch (\Exception $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente'], 500);
    }
  }

  public function update(Request $request, $id)
  {
    $cliente = Clientes::find($id);

    if (!$cliente) {
      return response()->json(['message' => 'Cliente não encontrado'], 404);
    }

    try {
      ClientesContato::where('Codigo_cliente', $id)->update([
        'Nome' => $request->empresa,
        'Contato_Emp' => $request->responsavel,
        'Telefone' => $request->fone_cont,
        'Celular' => $request->cel_cont,
        'Endereco' => $request->end_cont,
        'Bairro' => $request->bairro_cont,
        'Cidade' => strtoupper($request->cidade_cont),
        'UF' => strtoupper($request->uf),
        'Email' => $request->email_nfe,
        'CEP' => $request->cep_cont
      ]);

      return response()->json(['message' => 'Dados atualizados com sucesso'], 200);
    } catch (\Exception $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente'], 500);
    }
  }
}