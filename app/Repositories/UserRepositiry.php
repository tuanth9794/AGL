<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllPost()
    {
        return $this->user->all();
    }

}