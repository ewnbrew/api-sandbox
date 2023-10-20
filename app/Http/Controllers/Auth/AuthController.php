<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;

class AuthController extends Controller
{
  protected $authService;
  public function __construct(
    AuthService $authService
  )
  {
    $this->authService = $authService;
  }

  public function login(LoginRequest $request)
  {
    try {
      $validated = $request->validated();
      if(!$validated){
        return response()->json([
          'name' => 'Abigail',
          'state' => 'CA',
        ], 422);
      }

      $data = $this->authService->auththenticate($request->only(['email','password']));

      return response()->json([
        'status_code' => '200',
        'data' => $data
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status_code' => '500',
        'message' => throw new Exception($e->getMessage()),
      ], 500);
    }
  }

  public function register(RegisterRequest $request)
  {
    try {
      $validated = $request->validated();
      if(!$validated){
        return response()->json([
          'status_code' => 422,
          'message' => 'error',
        ], 422);
      }

      $data = $this->authService->register($request->only(['name','email','password']));

      return response()->json([
        'status_code' => '200',
        'data' => $data
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status_code' => '500',
        'message' => throw new Exception($e->getMessage()),
      ], 500);
    }
  }

}
