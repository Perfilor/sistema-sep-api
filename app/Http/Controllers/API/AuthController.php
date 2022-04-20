<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $this->validate($request, [
      'username' => 'required|string',
      'password' => 'required|string'
    ]);

    $credentials = [
      'username' => $request->input('username'),
      'password' => $request->input('password')
    ];

    if (!$token = auth('api')->setTTL(5256000)->attempt($credentials)) {
      return response(['message' => 'Invalid login credentials'], 403);
    }

    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth('api')->factory()->getTTL() * 60,
      'user' => auth('api')->user()
    ]);
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth('api')->logout();
    return response()->json(['message' => 'User successfully signed out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->createNewToken(auth('api')->refresh());
  }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function userProfile()
  {
    return response()->json(auth('api')->user());
  }
}