<?php

namespace App\Http\Controllers\Auth;

use App\Http\Api\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  protected $authService;
  public function __construct(
    AuthService $authService
  )
  {
    $this->authService = $authService;
  }

  public function login(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'message' => 'Validation failed',
          'errors' => $validator->errors(),
        ], 422);
      }
      
      $credentials = $request->only(['email','password']);
      $data = $this->authService->auththenticate($credentials);
      if ($data['data'] === false) {
        return ResponseFormatter::error(
          null,
          $data['message']
        );
      } else {
        return ResponseFormatter::success(
          $data['data'],
          'login succesfully'
        );
      }
    } catch (Exception $e) {
      return ResponseFormatter::error(
        null,
        $e->getMessage(),
        500
      );
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

      $credentials = $request->only(['name','email','password']);
      $data = $this->authService->register($credentials);

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

  public function details()
  {
    $user = auth()->user();
    return (!$user) ? response()->json(['message' => 'your not logged in']) : $user;
  }

  public function logout()
  {
    auth()->logout();
    return response()->json(['message' => 'Successfully logged out']);
  }

}
