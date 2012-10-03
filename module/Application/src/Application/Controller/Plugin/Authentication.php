<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\AbstractActionController;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authentication
 *
 * @author Thomas
 */
class Authentication extends AbstractActionController{
    
    public function hasIdentity()
    {
        $sm = $this->getServiceLocator();
        $auth = $sm->get('zfcuser_auth_service');
        if ($auth->hasIdentity()) {
            fb($auth->getIdentity()->getEmail());
        }
        else return $this->redirect()->toRoute('zfcuser');
    }
    
    
}

?>
