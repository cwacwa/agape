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
use Zend\View\Model\JsonModel;


class AdminController extends AbstractActionController
{
    
    protected $produitTable;
    protected $categorieTable;
    protected $photoTable;
    
    public function _construct()
    {
                
    }
    
    public function indexAction()
    {
        //$this->checkIdentity();
       
        $this->layout('layout/admin');
        return new ViewModel();
    }

    
    /**
     * Vraiment très mal fait pour le moment, très moche,je le sais.
     * @return \Zend\View\Model\JsonModel
     */
    public function updatexmlAction()
    {
        // création du fichier XML
        $xml = new \DOMDocument('1.0', 'utf-8');
        
        $catalogue = $xml->createElement('catalogue');
        
        $categoriesLevel1 = $this->getCategorieTable()->fetchAllRootLevel();
        
        // pour chaque catégorie de niveau 1, on ajoute une node au xml
        foreach ($categoriesLevel1 as $categorieLevel1) {

            $name = $xml->createElement('name', $categorieLevel1->name);
            $lien = $xml->createElement('lien', $categorieLevel1->lien);
            $parent = $xml->createElement('parent', $categorieLevel1->parent);

            $elementCategorieLevel1 = $xml->createElement('categorie-0');
            $elementCategorieLevel1->setAttribute('id', $categorieLevel1->id);
            $elementCategorieLevel1->appendChild($name);
            $elementCategorieLevel1->appendChild($lien);
            $elementCategorieLevel1->appendChild($parent);
            
            
            
            // pour chaque sous-catégorie on ajoute une node
            $categoriesLevel2 = $this->getCategorieTable()->fetchAllByParentId($categorieLevel1->id);
            if (count($categoriesLevel2)) {
                foreach ($categoriesLevel2 as $categorieLevel2) {
                    $name = $xml->createElement('name', $categorieLevel2->name);
                    $lien = $xml->createElement('lien', $categorieLevel2->lien);
                    $parent = $xml->createElement('parent', $categorieLevel2->parent);
                    
                    $elementCategorieLevel2 = $xml->createElement('categorie-1');
                    $elementCategorieLevel2->setAttribute('id', $categorieLevel2->id);
                    $elementCategorieLevel2->appendChild($name);
                    $elementCategorieLevel2->appendChild($lien);
                    $elementCategorieLevel2->appendChild($parent);
                    
                    // ajout des produits
                    $produits = $this->getProduitTable()->fetchAll($categorieLevel2->id);
                    if (count($produits)) {
                        foreach ($produits as $produit) {
                             $id = $xml->createElement('id', $produit->id);        
                             $name = $xml->createElement('name', $produit->name);        
                             $description = $xml->createElement('description', $produit->description);        
                             $info = $xml->createElement('info',$produit->info);        
                             
                             $elementProduit = $xml->createElement('produit');
                             $elementProduit->appendChild($id);
                             $elementProduit->appendChild($name);
                             $elementProduit->appendChild($description);
                             $elementProduit->appendChild($info);
                             
                             // on récupère les images de chaque produit
                            $photos = $this->getPhotoTable()->fetchAll($produit->id);
                            $elementPhotos = $xml->createElement('photos');
                            
                            if (count($photos)) {
                                foreach ($photos as $photo) {
                                    $elementPhoto = $xml->createElement('photo', $photo->url );     
                                    $elementPhoto->setAttribute('id', $photo->id);
                                    $elementPhotos->appendChild($elementPhoto);
                                }
                            }
                            $elementProduit->appendChild($elementPhotos);
                            $elementCategorieLevel2->appendChild($elementProduit);
                        }
                        
                    }
                    $elementCategorieLevel1->appendChild($elementCategorieLevel2);
                }
            } else { 
                // cas où la catégorie n'a pas de sous-catégorie, 
                // ajout des produits
                $produits = $this->getProduitTable()->fetchAll($categorieLevel1->id);
                
                if (count($produits)) {
                    foreach ($produits as $produit) {
                         $id = $xml->createElement('id', $produit->id);        
                         $name = $xml->createElement('name', $produit->name);        
                         $description = $xml->createElement('description', $produit->description);        
                         $info = $xml->createElement('info', $produit->info);        

                         $elementProduit = $xml->createElement('produit');
                         $elementProduit->appendChild($id);
                         $elementProduit->appendChild($name);
                         $elementProduit->appendChild($description);
                         $elementProduit->appendChild($info);
                         
                        // on récupère les images de chaque produit
                        $photos = $this->getPhotoTable()->fetchAll($produit->id);
                        $elementPhotos = $xml->createElement('photos');

                        if (count($photos)) {
                            foreach ($photos as $photo) {
                                   $elementPhoto = $xml->createElement('photo', $photo->url );     
                                   $elementPhoto->setAttribute('id', $photo->id);
                                   $elementPhotos->appendChild($elementPhoto);
                               }
                        }
                        $elementProduit->appendChild($elementPhotos);
                        $elementCategorieLevel1->appendChild($elementProduit);
                    }
                    
                }
            }
            
            $catalogue->appendChild($elementCategorieLevel1);
            
            
            
        }
        
        
        
        
        $xml->appendChild($catalogue);
        
        // suppression du fichier précédent
        unlink(PUBLIC_PATH . '/includes/base.xml');
        // sauvegarde du nouveau fichier
        $success = (bool)$xml->save(PUBLIC_PATH . '/includes/base.xml');
        
        $result = new JsonModel(
                array(
                    'success' => $success
                )
         );
        
        return $result;
    }
    
    
        public function getCategorieTable() {
        if (!$this->categorieTable) {
            $sm = $this->getServiceLocator();
            $this->categorieTable = $sm->get('Application\Model\CategorieTable');
        }
        return $this->categorieTable;
    }
    
     public function getProduitTable() {
        if (!$this->produitTable) {
            $sm = $this->getServiceLocator();
            $this->produitTable = $sm->get('Application\Model\ProduitTable');
        }
        return $this->produitTable;
    }
    
    public function getPhotoTable() {
        if (!$this->photoTable) {
            $sm = $this->getServiceLocator();
            $this->photoTable = $sm->get('Application\Model\PhotoTable');
        }
        return $this->photoTable;
    }
    
}
