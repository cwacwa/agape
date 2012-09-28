<?php
namespace Application\Service;

use Application\Model\User;
use Application\Model\UserTable;

class UserService 
{
            
    public function exists(User $user) 
    {
        
        $userTable = new UserTable();
        
        if ($userTable->exists($user->getLogin(), $user->getPwd())) {
            return true;
        } else {
            return false;
        }
    }
}