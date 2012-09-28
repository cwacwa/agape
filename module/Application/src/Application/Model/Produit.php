<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Produit implements InputFilterAwareInterface
{
    public $id;
    /**
     * Login
     * @var string
     */
    public $name;
    /**
     * Description
     * @var string
     */
    public $description;
    /**
     * Info
     * @var string
     */
    public $info;
    /**
     * 
     * @var integer
     */
    public $categorie_id;

    /**
     * @var Categorie
     */
    public $categorie;

    public function exchangeArray($data)
    {
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->info = (isset($data['info'])) ? $data['info'] : null;
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->categorie_id     = (isset($data['categorie_id'])) ? $data['categorie_id'] : null;
    }
    
    public function getCategorie_id() {
        return $this->categorie_id;
    }

    public function setCategorie_id($categorie_id) {
        $this->categorie_id = $categorie_id;
    }

    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'categorie_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 80,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'description',
                'required' => true,
                'filters'  => array(
                   
                ),
                'validators' => array(
                    
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'info',
                'required' => true,
                'filters'  => array(
                    
                ),
                'validators' => array(
                    
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getInfo() {
        return $this->info;
    }

    public function setInfo($info) {
        $this->info = $info;
        return $this;
    }

}
