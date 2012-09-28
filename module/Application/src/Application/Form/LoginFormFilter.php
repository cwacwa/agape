<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class LoginFormFilter extends InputFilter{
    public function __construct()    {
        $this->add(array(
            'name'       => 'login',
            'required'   => true,
            'filters' => array(
                array(
                    'name'    => 'Zend\Filter\StripTags',
                ),
                array(
                    'name'    => 'Zend\Filter\StringTrim',
                ),
            ),
        ));
        $this->add(array(
            'name'       => 'pwd',
            'required'   => true,
            'filters' => array(
                array(
                    'name'    => 'Zend\Filter\StripTags',
                ),
                array(
                    'name'    => 'Zend\Filter\StringTrim',
                ),
            ),
        ));
    }
}
