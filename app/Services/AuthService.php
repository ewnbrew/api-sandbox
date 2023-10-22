<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Exception;

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
      $email = (string) $credentials['email'];
      $password = (string) $credentials['password'];
      $message = $this->authRepository->checkCredentials($email, $password);
      
      $token = auth()->guard('api')->attempt($credentials);
      $user = auth()->guard('api')->user();

      $data =  [
        'user' => $user,
        'type' => 'bearer',
        'token' => $token,
      ];
      
      $reponse = [
        'data' => ($user || $token) ? $data : false,
        'message' => $message
      ];
      
      return $reponse;
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
