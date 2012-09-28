<?php
namespace Application\Form;
use Zend\Form\Form;

class ProduitForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setName('produit-edit');
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
            'name' => 'categorie_id',
            'required'   => true,
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Catégorie',
                'value_options' => array('0'=>'Aucune'),
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'required'   => false,
            'attributes' => array(
                'class' => 'long-text redactor',
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Description'
            ),
        ));
        $this->add(array(
            'name' => 'info',
            'required'   => false,
            'attributes' => array(
                'class' => 'long-text redactor',
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Infos'
            ),
        ));
                
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Modifier',
                'id' => 'submitbutton',
            ),
        ));
    }
    
    
}