<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Segmento;

class SegmentoController extends Controller
{
  public function get()
  {
    $data = Segmento::all();
    return response()->json($data);
  }
}