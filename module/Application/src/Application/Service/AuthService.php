<?php
namespace Application\Service;

use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\Adapter\DbTable as AuthAdapter,
    Zend\Db\Adapter\Adapter;

class AuthService
{
    private $authAdapter;
    private $auth;
    
    private function getDbAdapter()
    {
         return new Adapter(array(
                'driver' => 'Mysqli',
                'database' => 'agape',
                'username' => 'root',
                'password' => '0000'
        ));
    }
    
    public function __construct() {
        
        
        //$this->auth = new \Zend\Authentication\AuthenticationService();
    }
    
    public function authenticate(\Application\Model\User $user)
    {
        $auth = new \Zend\Authentication\AuthenticationService();
        $auth->setStorage(new SessionStorage('Application\Service'));
        
        $authAdapter = new AuthAdapter(
                    $this->getDbAdapter(),
                    'user',
                    'login',
                    'pwd'
                );
        
        $authAdapter->setIdentity($user->getLogin())
                          ->setCredential($user->getPwd());
        
        
        return $auth->authenticate($authAdapter);
        
        
        //$this->auth->authenticate($this->authAdapter);*/
        
    }
    
    public function hasIdentity() 
    {
        $auth = new \Zend\Authentication\AuthenticationService();
        return $auth->hasIdentity();
    }
    
    public function clearIdentity()
    {
        $auth = new \Zend\Authentication\AuthenticationService();
        $auth->clearIdentity();
    }
}