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
use Application\Form\ProduitForm;
use Application\Form\ImageUploadForm;
use Application\Model\Produit;
use Application\Model\Photo;
use Application\Helper\ProduitHelper;
use Zend\View\Model\JsonModel;

class ProduitsController extends AbstractActionController {

    protected $produitTable;
    protected $categorieTable;

    public function indexAction() {
        $this->layout('layout/admin');
        return new ViewModel(array(
                    'produits' => $this->getProduitTable()->fetchAll(),
                ));
    }

    public function addAction() {
        $this->layout('layout/admin');
        $form = new ProduitForm();

        $request = $this->getRequest();
        $form->get('submit')->setAttribute('value', 'Enregistrer le produit et afficher le formulaire d\'envoi des images');
        $form->get('categorie_id')->setAttribute('options', $this->getCategorieOptionsArray());

        if ($request->isPost()) {
            $produit = new Produit();
            $form->setInputFilter($produit->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $produit->exchangeArray($form->getData());
                $id = $this->getProduitTable()->saveProduit($produit);
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('produits', array('action' => 'edit', 'id' => $id));
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $this->layout('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('produits', array(
                        'action' => 'add'
                    ));
        }

        $produit = $this->getProduitTable()->getProduit($id);
        $form = new ProduitForm();
        $form->get('categorie_id')->setAttribute('options', $this->getCategorieOptionsArray());
        $form->bind($produit);
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->setInputFilter($produit->getInputFilter());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProduitTable()->saveProduit($form->getData());

                // Redirect to list of products
                return $this->redirect()->toRoute('produits');
            }
        }

        $formUpload = new ImageUploadForm();
        $formUpload->get('produit_id')->setValue($id);

        // on récupère les images déjà existantes en BDD
        $imagesProduits = $this->getPhotoTable()->fetchAll($id);
        
        return array(
            'id' => $id,
            'form' => $form,
            'imageUploadForm' => $formUpload,
            'imagesProduits' => $imagesProduits,
        );
    }

    public function deleteAction() {
        $this->layout('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('produits');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');

            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->getProduitTable()->deleteProduit($id);
                ProduitHelper::deleteImagesFiles($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('produits');
        }

        return array(
            'id' => $id,
            'produit' => $this->getProduitTable()->getProduit($id)
        );
    }

    public function uploadimageAction() {
        $this->layout('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('produits');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = new ImageUploadForm();
            $form->setData($request->getPost());

            // on enregistre l'image dans le bon dossier
            if ($_FILES['url']['tmp_name']) {
                $image = ProduitHelper::uploadImage($id);
                if ($image) {
                    $photo = new Photo();
                    $photo->setProduit_id($id)->setUrl($image);   
                    // enregistrement de la photo en BDD
                    $this->getPhotoTable()->savePhoto($photo);
                } else {
                    $msg = "Erreur durant l'upload";
                }
            } else {
                $msg = "Aucun fichier n'a été uploadé !";
            }
        }
        return $this->redirect()->toRoute(
                        'produits/', array(
                            'action' => 'edit',
                            'id' => $form->get('produit_id')->getValue()
                        )
        );
    }

    public function deleteimageAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();
        $id = $post['id'];
        
        $photo = $this->getPhotoTable()->getPhoto($id);
        $success = false;
        if (ProduitHelper::deleteImage($photo->url)) {
            if ($this->getPhotoTable()->deletePhoto($photo->id)){
                $success = true;
            } 
        } 
        
        // récupération des images du produit concerné
        $result = new JsonModel(
                array(
                    'images' => $this->getPhotoTable()->fetchAll($photo->produit_id, true),
                )
         );
        
        return $result;
    }
    
    public function getProduitTable() {
        if (!$this->produitTable) {
            $sm = $this->getServiceLocator();
            $this->produitTable = $sm->get('Application\Model\ProduitTable');
        }
        return $this->produitTable;
    }

    public function getCategorieTable() {
        if (!$this->categorieTable) {
            $sm = $this->getServiceLocator();
            $this->categorieTable = $sm->get('Application\Model\CategorieTable');
        }
        return $this->categorieTable;
    }
    
    public function getPhotoTable() {
        if (!$this->photoTable) {
            $sm = $this->getServiceLocator();
            $this->photoTable = $sm->get('Application\Model\PhotoTable');
        }
        return $this->photoTable;
    }

    private function getCategorieOptionsArray($id = null) {
        $categories = $this->getCategorieTable()->fetchAll();

        foreach ($categories as $categorie) {
            $array[$categorie->id] = $categorie->name;
        }

        return $array;
    }

}
