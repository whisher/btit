<?php
namespace BtitUser\Form;

use BtitBase\InputFilter\ProvidesEventsInputFilter;

class LoginFilter extends ProvidesEventsInputFilter
{
    public function __construct()
    {
        
         $this->add(array(
            'name'       => 'identity',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim','name' => 'StripTags'),
            ),
        ));
    
        $this->add(array(
            'name'       => 'credential',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim','name' => 'StripTags'),
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }
}
