<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Photo implements InputFilterAwareInterface
{
    public $id;
    /**
     * @var string
     */
    public $url;
    /**
     *
     * @var integer
     */
    public $produit_id;
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->produit_id = (isset($data['produit_id'])) ? $data['produit_id'] : null;
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
                'name'     => 'produit_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'url',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'IsImage',
                        'options' => array(
                            
                        ),
                    ),
                ),
            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getProduit_id() {
        return $this->produit_id;
    }

    public function setProduit_id($produit_id) {
        $this->produit_id = $produit_id;
        return $this;
    }

        public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
