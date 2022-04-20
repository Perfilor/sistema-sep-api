<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;

class UserController extends Controller
{
  public function register(Request $request)
  {
    $this->validate($request, [
      'username' => 'required|string',
      'name' => 'required|string',
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    $user = User::create([
      'username' => $request->input('username'),
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password')),
      'api_token' => Str::random(60),
    ]);

    return response(['message' => 'User created', 'user' => $user]);
  }

  public function userInfo()
  {
    $user = auth()->user();

    return response()->json(['user' => $user], 200);
  }
}