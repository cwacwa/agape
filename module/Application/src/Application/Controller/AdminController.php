<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel,
 \Application\Service\AuthService;

class AdminController extends AbstractActionController
{
    
    public function _construct()
    {
                
    }
    
    private function checkIdentity() {
       //$authService = new AuthService();
       var_dump (AuthService::hasIdentity());exit;
       /*if (!$authService->authenticate()) {
           return $this->redirect()->toRoute('auth');
       }*/
    }
    
    public function indexAction()
    {
        //$this->checkIdentity();
       
        $this->layout('layout/admin');
        return new ViewModel();
    }

}
