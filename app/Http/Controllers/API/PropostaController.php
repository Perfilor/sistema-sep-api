<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\ClientesContato;
use App\Models\CondicaoPagamento;
use App\Models\Frete;
use App\Models\Imposto;
use App\Models\Proposta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropostaController extends Controller
{
  public function getById($id)
  {
    $proposta = new Proposta();

    if (Auth::user()->role === 'representante') {
      $proposta->where('Responsavel', Auth::user()->username)->first();
    }

    $data = $proposta->where('Num_prop', $id)->first();

    if (!$data) {
      return response()->json(['message' => 'Proposta não encontrada'], 404);
    }

    return response()->json($data);
  }

  public function store(Request $request)
  {
    $cliente = Clientes::select(
      'Id AS codcli',
      'Documento AS CNPJ',
      'RazaoSocial',
      'Endereco',
      'Bairro',
      'Cidade',
      'UF',
      'Email',
      'RespCadastro AS Responsavel',
      'Cep AS CEP',
      'Contribuinte',
      'Telefone',
      'IE'
    )
      ->where('Documento', $request->documento)->get()[0];

    $contato = ClientesContato::select(
      'Nome AS RazaoSocialC',
      'Endereco AS End_Contato',
      'Bairro AS Bairro_Contato',
      'Cidade AS Cidade_Contato',
      'CEP AS Cep_Contato',
      'Telefone AS Telefone_Contato',
      'Celular AS Cel_Contato',
      'Email AS Email_Contato'
    )
      ->where('Codigo_cliente', $cliente['codcli'])->get()[0];

    $condicaoPagamento = CondicaoPagamento::select('Descricao AS Pagamento', 'Mult_enc', 'BNDES')
      ->where('Descricao', $request->condicao_pagamento)->get()[0];

    $contrib = $cliente->Contribuinte === 'Sim' ?  'S' : 'N';
    $impostos = Imposto::where('Origem', 'SP')->where('Destino', $cliente->UF)->where('Contribuinte', $contrib)->first();

    try {
      $proposta = new Proposta();
      $proposta->Data = Carbon::now();
      $proposta->CNPJ = $cliente->CNPJ;
      $proposta->RazaoSocial = $cliente->RazaoSocial;
      $proposta->CEP = $cliente->CEP;
      $proposta->Endereco = $cliente->Endereco;
      $proposta->Bairro = $cliente->Bairro;
      $proposta->Cidade = $cliente->Cidade;
      $proposta->IE = $cliente->IE;
      $proposta->uf_clientefinal = $cliente->UF;
      $proposta->email_nfe = $cliente->Email;
      $proposta->Telefone = $cliente->Telefone;
      $proposta->Responsavel = $cliente->Responsavel;
      $proposta->contribuinte = $contrib;
      $proposta->codcli = $cliente->codcli;
      $proposta->RazaoSocialC = $contato->RazaoSocialC;
      $proposta->End_Contato = $contato->End_Contato;
      $proposta->Bairro_Contato = $contato->Bairro_Contato;
      $proposta->Cidade_Contato = $contato->Cidade_Contato;
      $proposta->Cep_Contato = $contato->Cep_Contato;
      $proposta->Telefone_Contato = $contato->Telefone_Contato;
      $proposta->Cel_Contato = $contato->Cel_Contato;
      $proposta->Email_Contato = $contato->Email_Contato;
      $proposta->Pagamento = $condicaoPagamento->Pagamento;
      $proposta->Mult_enc = $condicaoPagamento->Mult_enc;
      $proposta->BNDES = $condicaoPagamento->BNDES;
      $proposta->Prazo = $request->prazo;
      $proposta->Classificacao = $request->Classificacao;
      $proposta->Num_prop = $this->_lastRecord() + 1;
      $proposta->AI = $impostos->AI;
      $proposta->AE = $impostos->AE;
      $proposta->DIFAL = $impostos->DIF;
      $proposta->Impostos = $impostos->Aliquota;
      $proposta->ICMS_T = $impostos->Icms;
      $proposta->save();
      return response()->json(['message' => 'Proposta cadastrada com sucesso', 'proposta' => $proposta->Num_prop], 203);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['message' => 'Erro ao cadastrar proposta', 'error' => $e], 500);
    }
  }

  public function update(Request $request, $id)
  {
    $proposta = Proposta::select('Repr')->where('Num_prop', $id)->first();

    if (!$proposta) {
      return response()->json(['message' => 'Não encontramos a proposta'], 404);
    }

    if (Auth::user()->role === 'representante' && $proposta->Repr !== Auth::user()->role) {
      return response()->json(['message' => 'Erro ao processar informação'], 500);
    }

    $condicaoPagamento = CondicaoPagamento::select('Descricao AS Pagamento', 'Mult_enc', 'BNDES')
      ->where('Descricao', $request->Pagamento)->get()[0];
    $complementoFrete = Frete::select('Obs')->where('Frete', $request->Frete)->first();

    try {
      Proposta::where('Num_prop', $id)->update([
        'Status' => $request->Status,
        'Status_Aberta' => $request->Status_Aberta,
        'Classificacao' => $request->Classificacao,
        'OC' => $request->OC,
        'Prazo' => $request->Prazo,
        'moeda' => $request->moeda,
        'Pagamento' => $request->Pagamento,
        'Mult_enc' => $condicaoPagamento->Mult_enc,
        'BNDES' => $condicaoPagamento->BNDES,
        'Frete' => $request->Frete,
        'Complefrete' => $complementoFrete->Obs
      ]);

      return response()->json(['message' => 'Proposta atualizada com sucesso'], 200);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['message' => 'Erro ao atualizar proposta', 'error' => $e], 500);
    }
  }

  private function _lastRecord()
  {
    $last = DB::table('tab_propcliente')->latest('contador')->first();
    return intval($last->contador);
  }
}