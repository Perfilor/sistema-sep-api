<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrazoPagamento;

class PrazoPagamentoController extends Controller
{
  public function get()
  {
    $data = PrazoPagamento::all();
    return response()->json($data);
  }
}