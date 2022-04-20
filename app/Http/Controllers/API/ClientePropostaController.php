<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\ClientesContato;
use App\Models\Imposto;
use App\Models\Proposta;

class ClientePropostaController extends Controller
{
  public function update(Request $request, $numeroProposta)
  {

    $this->validate($request, [
      'CNPJ' => 'required',
      'RazaoSocial' => 'required',
      'Email' => 'required|email',
      'email_nfe' => 'required|email'
    ]);

    $propostaComercial = Proposta::select('Num_prop', 'CNPJ', 'RazaoSocial')->where('Num_prop', $numeroProposta)->first();

    if (!$propostaComercial) {
      return response()->json(['message' => 'Proposta não encontrada'], 404);
    }

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
      ->where('Documento', $request->CNPJ)->get()[0];

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

    $contrib = $cliente->Contribuinte === 'Sim' ?  'S' : 'N';
    $impostos = Imposto::where('Origem', 'SP')->where('Destino', $cliente->UF)->where('Contribuinte', $contrib)->first();

    try {
      $query = Proposta::where('Num_prop', $propostaComercial->Num_prop)->update([
        'CNPJ' => $cliente->CNPJ,
        'RazaoSocial' => $cliente->RazaoSocial,
        'CEP' => $cliente->CEP,
        'Endereco' => $cliente->Endereco,
        'Bairro' => $cliente->Bairro,
        'Cidade' => $cliente->Cidade,
        'IE' => $cliente->IE,
        'Uf' => $cliente->UF,
        'email_nfe' => $request->email_nfe,
        'Telefone' => $cliente->Telefone,
        'Responsavel' => $cliente->Responsavel,
        'contribuinte' => $contrib,
        'codcli' => $cliente->codcli,
        'RazaoSocialC' => $contato->RazaoSocialC,
        'End_Contato' => $contato->End_Contato,
        'Bairro_Contato' => $contato->Bairro_Contato,
        'Cidade_Contato' => $contato->Cidade_Contato,
        'Cep_Contato' => $contato->Cep_Contato,
        'Telefone_Contato' => $contato->Telefone_Contato,
        'Cel_Contato' => $contato->Cel_Contato,
        'Email_Contato' => $request->Email,
        'AI' => $impostos->AI,
        'AE' => $impostos->AE,
        'DIFAL' => $impostos->DIF,
        'Impostos' => $impostos->Aliquota,
        'ICMS_T' => $impostos->Icms
      ]);

      return response()->json(['message' => 'Cliente atualizado com sucesso'], 200);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['message' => 'Erro ao cadastrar cliente', 'error' => $e], 500);
    }
  }
}