<?php
namespace Application\Model;

class User 
{
    private $id;
    /**
     * Login
     * @var string
     */
    private $login;
    /**
     * Password
     * @var string
     */
    private $pwd;
    
    
    public function __construct() 
    {
        
    }
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->pwd = (isset($data['pwd'])) ? sha1($data['pwd']) : null;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function setPwd($pwd) {
        $this->pwd = sha1($pwd);
        return $this;
    }


}
