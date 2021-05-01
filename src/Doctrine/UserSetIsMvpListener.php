<?php


namespace App\Doctrine;


use App\Entity\User;

class UserSetIsMvpListener
{
    public function postLoad(User $user)
    {
        $user->setIsMvp(strpos($user->getUsername(), 'cheese') !== false);
    }
}
