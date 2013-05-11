<?php
namespace BtitUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class Base extends ProvidesEventsForm
{
    public function __construct($name=null)
    {
        parent::__construct($name);

        
        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => 'First Name',
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'First Name'
            ),
        ));

        $this->add(array(
            'name' => 'surname',
            'options' => array(
                'label' => 'Last Name',
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Last Name'
            ),
        ));
        
       
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'Your Email'
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

        $this->add(array(
            'name' => 'repassword',
            'options' => array(
                'label' => 'Retype password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

        $this->add(array(
            'name' => 'sbt-user',
            'attributes' => array(
                'type'  => 'submit',
                'id' => 'sbt-user',
                'class'=>'sbt'
            ),
        ));

    }
}
