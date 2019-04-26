<?php

namespace App\Form\Model;

use App\Entity\User;

class UserRegisterModel
{
    /**
     * @Assert\Valid()
     */
    private $user;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user = null)
    {
        $this->user = $user;
    }
}