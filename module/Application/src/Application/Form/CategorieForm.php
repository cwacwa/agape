<?php
namespace Application\Form;
use Zend\Form\Form;

class CategorieForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setName('categorie-edit');
        $this->setAttribute('method', 'post');
       
        $this->add(array(
            'name' => 'id',
            'required'   => true,
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'required'   => true,
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nom'
            ),
        ));
        
        $this->add(array(
            'name' => 'parent',
            'required'   => true,
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Catégorie Parente',
                'value_options' => array('0'=>'Aucune'),
            ),
        ));
        
        $this->add(array(
            'name' => 'lien',
            'required'   => false,
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Lien (facultatif)'
            ),
        ));
                
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Sauvegarder',
                'id' => 'submitbutton',
            ),
        ));
    } 
    
}