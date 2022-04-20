<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StatusGeral;
use Illuminate\Http\Request;

class StatusGeralController extends Controller
{
  public function get()
  {
    $status = StatusGeral::all();
    return response()->json($status);
  }
}