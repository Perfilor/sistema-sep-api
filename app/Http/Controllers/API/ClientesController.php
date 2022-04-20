<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
  public function get(Request $request)
  {
    $clientes = new Clientes();

    if ($request->filter) {
      $filtro = $request->filter;
      $clientes = $clientes->orWhere("Documento", "like", "%$filtro%")->orWhere("RazaoSocial", "like", "%$filtro%");
    }

    if (Auth::user()->role === 'representante') {
      $clientes->where('RespCadastro', Auth::user()->username);
    }

    $data = $clientes->orderByDesc('created_at')->paginate(10);

    return response()->json($data);
  }

  public function getById($id)
  {
    $cliente = Clientes::select('Id', 'Tipo', 'Documento', 'RazaoSocial', 'Endereco', 'Bairro', 'Cidade', 'UF', 'IE', 'Telefone', 'Email', 'Celular', 'Segmento', 'Contribuinte', 'Cep')->find($id);

    if (!$cliente) {
      return response()->json(['message' => 'Cliente não encontrado'], 404);
    }

    return response()->json($cliente);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'documento' => 'string',
      'nome' => 'required',
      'cep' => 'required',
      'endereco' => 'required',
      'bairro' => 'required',
      'cidade' => 'required',
      'uf' => 'required',
      'icms' => $request->tipo === 'Pessoa Física' ? '' : 'required',
      'inscricao_estadual' => $request->tipo === 'Pessoa Física' ? '' : 'required',
      'segmento' => 'required',
      'telefone' => 'required',
      'tipo' => 'required'
    ]);

    $cliente = Clientes::where('documento', $request->documento)->get();

    if (!$cliente->isEmpty()) {
      return response()->json(['message' => 'Cliente já possui cadastro no sistema'], 500);
    }

    try {
      $cliente = Clientes::create([
        'Tipo' => $request->tipo,
        'Documento' => $request->documento,
        'IE' => $request->inscricao_estadual,
        'RazaoSocial' => mb_strtoupper($request->nome, "UTF-8"),
        'Responsavel' => $request->responsavel,
        'Telefone' => $request->telefone,
        'Celular' => $request->celular,
        'Endereco' => mb_strtoupper($request->endereco, "UTF-8"),
        'Bairro' => mb_strtoupper($request->bairro, "UTF-8"),
        'Cidade' => mb_strtoupper($request->cidade, "UTF-8"),
        'UF' => mb_strtoupper($request->uf, "UTF-8"),
        'Contribuinte' => $request->icms,
        'Segmento' => $request->segmento,
        'Email' => $request->email,
        'Cep' => $request->cep,
        'RespCadastro' => Auth::user()->username
      ]);

      return response()->json(['message' => 'Cliente cadastrado com sucesso', 'data' => $cliente], 203);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente', 'error' => $e], 500);
    }
  }

  public function update(Request $request, $idCustomer)
  {
    $this->validate($request, [
      'documento' => 'string',
      'nome' => 'required',
      'cep' => 'required',
      'endereco' => 'required',
      'bairro' => 'required',
      'cidade' => 'required',
      'uf' => 'required',
      'icms' => $request->tipo === 'Pessoa Física' ? '' : 'required',
      'inscricao_estadual' => $request->tipo === 'Pessoa Física' ? '' : 'required',
      'segmento' => 'required',
      'telefone' => 'required',
      'tipo' => 'required'
    ]);

    try {
      Clientes::where('Id', $idCustomer)->update([
        'Segmento' => 12213213,
        'Tipo' => $request->tipo,
        'Documento' => $request->documento,
        'IE' => $request->inscricao_estadual,
        'RazaoSocial' => mb_strtoupper($request->nome, "UTF-8"),
        'Telefone' => $request->telefone,
        'Celular' => $request->celular,
        'Endereco' => mb_strtoupper($request->endereco, "UTF-8"),
        'Bairro' => mb_strtoupper($request->bairro, "UTF-8"),
        'Cidade' => mb_strtoupper($request->cidade, "UTF-8"),
        'UF' => mb_strtoupper($request->uf, "UTF-8"),
        'Contribuinte' => $request->icms,
        'Email' => $request->email,
        'Cep' => $request->cep,
        'RespCadastro' => Auth::user()->username,
        'Segmento' => $request->segmento
      ]);

      return response()->json(['message' => 'Dados atualizados com sucesso'], 200);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente', 'error' => $e], 500);
    }
  }

  public function remove($idCustomer)
  {
  }
}