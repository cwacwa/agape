<?php
namespace Application\Form;
use Zend\Form\Form;


class ImageUploadForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setName('upload-image');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
               
        $this->add(array(
            'name' => 'produit_id',
            'required'   => true,
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'url',
            'required'   => true,
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => 'Fichier (images jpg, jpeg, png uniquement)',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'required'   => true,
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Envoyer',
            ),
        ));
    }
}