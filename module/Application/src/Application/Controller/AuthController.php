<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Application\Form\LoginForm,
    Application\Model\User,    
    Application\Service\UserService,
    Application\Service\AuthService;
    

class AuthController extends AbstractActionController
{
    protected $userTable;
    
    public function __construct() {
        $this->layout('layout/admin');
        
    }
    
    public function loginAction()
    {
        
    } 
    public function signupAction()
    {
        
    } 
    public function logoutAction()
    {
        
    }
    public function homeAction()
    {
        $form = new LoginForm();
        
        $request = $this->getRequest();
                
        if ($request->isPost()) {
           $form->setData($request->getPost());
           
           if ($form->isValid()) {
               $user = new User();
               $user->exchangeArray($form->getData());
               
               // on vérifie que l'utilisateur existe en base
               if ($this->getUserTable()->exists($user->getLogin(), $user->getPwd())) {
                   // authentification Zend
                   $authService = new AuthService();
                   $authService->authenticate($user);
                   var_dump($authService->hasIdentity()); exit;
                   // on redirige vers l'admin
                   return $this->redirect()->toRoute('admin');
               } else {
                    return $this->redirect()->toRoute('auth');
               }
               
            } 
        } 
        $this->layout('layout/admin');
        return array(
            'form' => $form,
        );
        
    }
    
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Application\Model\UserTable');
        }
        return $this->userTable;
    }
}