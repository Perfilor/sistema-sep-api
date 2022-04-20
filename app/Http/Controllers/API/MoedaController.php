<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Moeda;

class MoedaController extends Controller
{
  public function get()
  {
    $data = Moeda::all();
    return response()->json($data);
  }
}