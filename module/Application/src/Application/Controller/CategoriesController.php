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
use Zend\View\Model\ViewModel;
use Application\Form\CategorieForm;
use Application\Model\Categorie;
 

class CategoriesController extends AbstractActionController
{
     
    protected $categorieTable;
    
    
    public function indexAction()
    {
              
       $this->layout('layout/admin');
       return new ViewModel(array(
            'categories' => $this->getCategorieTable()->fetchAll(),
        ));
    }
    
    public function addAction()
    {
        
        $this->layout('layout/admin');
        $form = new CategorieForm();
        
        // ajout des catégories disponibles dans le select des cat parentes
        $form->get('parent')->setAttribute('options', $this->getParentOptionsArray());
         
        $request = $this->getRequest();
       
        if ($request->isPost()) {
            
            $categorie = new Categorie();
            $form->setData($request->getPost());
            $form->setInputFilter($categorie->getInputFilter());
            
            if ($form->isValid()) {
                $categorie->exchangeArray($form->getData());
                
                $this->getCategorieTable()->saveCategorie($categorie);

                // Redirect to list of categories
                return $this->redirect()->toRoute('categories');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction()
    {
       
        $this->layout('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('categories', array(
                'action' => 'add'
            ));
        }
        
        $categorie = $this->getCategorieTable()->getCategorie($id);
        $produits = $this->getProduitTable()->fetchAll($id);
        $form  = new CategorieForm();
        
        // ajout des catégories disponibles dans le select des cat parentes
        $form->get('parent')->setAttribute('options', $this->getParentOptionsArray($id));
        
        $form->bind($categorie);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $form->setInputFilter($categorie->getInputFilter());
            
            if ($form->isValid()) {
                $this->getCategorieTable()->saveCategorie($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('categories');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'produits' => $produits,
        );
    }
    
    
    public function deleteAction()
    {
        
         $this->layout('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('categories');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');

            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->getCategorieTable()->deleteCategorie($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('categories');
        }

        return array(
            'id'    => $id,
            'categorie' => $this->getCategorieTable()->getCategorie($id)
        );
    }
    
    
    public function getCategorieTable()
    {
        if (!$this->categorieTable) {
            $sm = $this->getServiceLocator();
            $this->categorieTable = $sm->get('Application\Model\CategorieTable');
        }
        return $this->categorieTable;
    }
    
    public function getProduitTable()
    {
        if (!$this->produitTable) {
            $sm = $this->getServiceLocator();
            $this->produitTable = $sm->get('Application\Model\ProduitTable');
        }
        return $this->produitTable;
    }
    
    private function getParentOptionsArray($id = null)
    {
        $categories = $this->getCategorieTable()->fetchAllRootLevel($id);
        $array = array('0' => 'Aucune');
                
        foreach ($categories as $categorie) {
            $array[$categorie->id] = $categorie->name;
        }
        
        return $array;
    }
    
}
