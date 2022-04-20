<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api', 'permission:admin'])->get('/users', function (Request $request) {
  return $request->user();
});

Route::post('/login', 'API\AuthController@login');

Route::prefix('/user')->group(function () {
  Route::post('/register', 'API\UserController@register');
});

Route::middleware('auth:api')->group(function () {
  // User logged information
  Route::get('/me', 'API\AuthController@userProfile');

  //Proposta
  Route::get('/proposta/{id}', 'API\PropostaController@getById');
  Route::post('/proposta', 'API\PropostaController@store');
  Route::put('/propostas/{id}', 'API\PropostaController@update');
  Route::put('/propostas/{id}/cliente', 'API\ClientePropostaController@update');

  //Itens da proposta
  Route::get("/propostas/{id}/itens", 'API\PropostaItensController@get');

  //Cliente Entrega
  Route::get('/proposta/{id}/entrega', 'API\ClienteEntregaController@getById');
  Route::put('/proposta/{id}/entrega', 'API\ClienteEntregaController@update');

  //Cliente Cobranca
  Route::get('/proposta/{id}/cobranca', 'API\ClienteCobrancaController@getById');
  Route::put('/proposta/{id}/cobranca', 'API\ClienteCobrancaController@update');

  //Segment
  Route::get('/clientes/segmentos', 'API\SegmentoController@get');

  // Company Group
  Route::get('/clientes/grupo-empresa', 'API\GrupoEmpresaController@get');

  //Customer
  Route::get('/clientes', 'API\ClientesController@get');
  Route::get('/clientes/{id}', 'API\ClientesController@getById');
  Route::post('/clientes', 'API\ClientesController@store');
  Route::put('/clientes/{id}', 'API\ClientesController@update');

  //Contact
  Route::get('/clientes/{id}/contato', 'API\ClientesContatoController@getById');
  Route::post('/clientes/{id}/contato', 'API\ClientesContatoController@store');
  Route::put('/clientes/{id}/contato', 'API\ClientesContatoController@update');

  //Condicao Pagamento
  Route::get('/condicao-pagamento', 'API\CondicaoPagamentoController@get');

  //Moeda
  Route::get('/moeda', 'API\MoedaController@get');

  //Prazo Pagamento
  Route::get('/prazo-pagamento', 'API\PrazoPagamentoController@get');

  //Status Geral
  Route::get('/status/geral', 'API\StatusGeralController@get');

  //Status Comercial
  Route::get('/status/comercial', 'API\StatusComercialController@get');

  //Frete
  Route::get('/fretes', 'API\FreteController@get');
});