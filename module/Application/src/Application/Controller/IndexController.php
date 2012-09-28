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

class IndexController extends AbstractActionController
{
    /**
     * Charge toutes les données du site, les met en cache 
     * et les retourne à la vue
     * @return \Zend\View\Model\ViewModel
     */  
    public function indexAction()
    {
        // chargement de toutes les catégories
        $categories = $this->getCategorieTable()->fetchAll(true);
        
        return array(
            'categories' => $categories,
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
    
}
