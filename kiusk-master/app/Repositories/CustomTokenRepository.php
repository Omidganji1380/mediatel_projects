<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;

class CustomTokenRepository extends DatabaseTokenRepository
{
    public function createToken($user)
    {
        $length = 5; // Customize the length of the token here
        $token = Str::random($length);

        $this->getTable()->insert($this->getPayload($user->getEmailForPasswordReset(), $token));

        return $token;
    }
}
