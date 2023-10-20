<?php

namespace App\Repositories;

use App\Models\User;
use Exception;

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
} 