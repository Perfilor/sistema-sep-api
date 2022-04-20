<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imposto;

class ImpostoController extends Controller
{
  public function get(Request $request)
  {
    $this->validate($request, [
      'origem' => 'required|max:2',
      'destino' => 'required|max:2',
      'contribuinte' => 'required'
    ]);

    $imposto = Imposto::select('Impostos', 'Consumo', 'Revenda', 'Icms', 'AI', 'AE', 'DIF', 'FCB', 'Mult_Dif', 'Z_Icms', 'Z+Ipi', 'NCM', 'IPI', 'codop', 'Aliquota', 'Difal', 'Vdifal')->where('Origem', $request->origem)
      ->where('Destino', $request->destino)
      ->where('Contribuinte', $request->contribuinte)
      ->first();

    return response()->json($imposto);
  }
}