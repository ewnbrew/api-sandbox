<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
  private $user;
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function generateAccount($data)
  {
    return $this->user->create($data);
  }

  public function checkCredentials($email, $password)
  {
    $user = $this->user->where('email', $email)->first();
    return (!$user) 
            ? 'user not found' 
            : (
              !Hash::check($password, $user->password) 
              ? 'password invalid' 
              : true
            );
  }
} 