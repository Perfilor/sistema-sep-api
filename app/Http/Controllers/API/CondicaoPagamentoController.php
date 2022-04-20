<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CondicaoPagamento;
use App\Models\Segmento;

class CondicaoPagamentoController extends Controller
{
  public function get()
  {
    $data = CondicaoPagamento::where('Libera', 'S')->get();
    return response()->json($data);
  }
}