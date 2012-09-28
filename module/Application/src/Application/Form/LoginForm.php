<?php
namespace Application\Form;
use Zend\Form\Form,    Application\Form\LoginFormFilter;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setName('authentication');
        $this->setAttribute('method', 'post');
        
        $inputFilter = new LoginFormFilter();
        
        $this->setInputFilter($inputFilter);
        $this->add(array(
            'name' => 'login',
            'required'   => true,
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Login'
            ),
        ));
        
        $this->add(array(
            'name' => 'pwd',
            'required'   => true,
            'attributes' => array(
                'type' => 'password',
                'label' => 'Mot de passe',
            ),
            'options' => array(
                'label' => 'Mot de passe'
            ),
        ));
                
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'S\'identifier',
                'id' => 'submitbutton',
            ),
            'options' => array(
                'label' => 'Login'
            ),
        ));
    }
    
    
}