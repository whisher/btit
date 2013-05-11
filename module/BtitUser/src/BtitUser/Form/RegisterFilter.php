<?php
namespace BtitUser\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class RegisterFilter extends ProvidesEventsInputFilter
{
    
    protected $emailValidator;
    /**
     * @var RegistrationOptionsInterface
     */
    protected $options;

    public function __construct($emailValidator)
    {
        
        $this->emailValidator = $emailValidator;
        

        $this->add(array(
            'name'       => 'firstname',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim','name' => 'StripTags')),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255,
                    ),
                )
            ),
        ));
        
        $this->add(array(
            'name'       => 'surname',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim','name' => 'StripTags')),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255,
                    ),
                )
            ),
        ));

        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
                $this->emailValidator
            ),
        ));

        $this->add(array(
            'name'       => 'password',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'repassword',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    public function getEmailValidator()
    {
        return $this->emailValidator;
    }

    public function setEmailValidator($emailValidator)
    {
        $this->emailValidator = $emailValidator;
        return $this;
    }

}
