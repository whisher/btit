<?php
namespace BtitUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;


class Login extends ProvidesEventsForm
{
    

    public function __construct($name = null)
    {
        parent::__construct($name);

        $csrf = new Element\Csrf('loginCsrf');
        $csrf->getCsrfValidator()->setTimeout(600);
        $this->add($csrf);
        
        $this->add(array(
            'name' => 'identity',
            'options' => array(
                'label' => 'Username or email',
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Username or email'
            ),
        ));

        $this->add(array(
            'name' => 'credential',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password'
            ),
        ));

        $this->add(array(
            'name' => 'sbt-user',
            'attributes' => array(
                'type'  => 'submit',
                'value'=>'Login',
                'id' => 'sbt-user',
                'class'=>'sbt'
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    
}
