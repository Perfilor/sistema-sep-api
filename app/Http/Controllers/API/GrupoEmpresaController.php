<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GrupoEmpresa;

class GrupoEmpresaController extends Controller
{
  public function get()
  {
    $data = GrupoEmpresa::all();
    return response()->json($data);
  }
}