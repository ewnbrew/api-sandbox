<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService 
{
  protected $authRepository;
  public function __construct(
    AuthRepository $authRepository
  )
  {
    $this->authRepository = $authRepository;
  }

  public function auththenticate($credentials)
  {
    try {
      if($token = auth()->guard('api')->attempt($credentials)){
        $user = auth()->guard('api')->user();
        return [
          'user' => $user,
          'token' => $token,
          'type' => 'bearer'
        ];
      } else {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
    } catch(Exception $e) {
      return $e->getMessage();
    }
  }

  public function register($data)
  {
    try {
      $response = $this->authRepository->generateAccount($data);
      return $response;
    } catch(Exception $e) {
      return $e->getMessage();
    }
  }
}
