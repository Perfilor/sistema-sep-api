<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StatusComercial;
use Illuminate\Http\Request;

class StatusComercialController extends Controller
{
  public function get()
  {
    $status = StatusComercial::all();
    return response()->json($status);
  }
}