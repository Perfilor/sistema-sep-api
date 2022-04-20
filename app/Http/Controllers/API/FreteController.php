<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frete;

class FreteController extends Controller
{
  public function get()
  {
    $fretes = Frete::where('Liberado', 'S')->get();
    return response()->json($fretes);
  }
}