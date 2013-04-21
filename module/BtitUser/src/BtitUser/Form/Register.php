<?php
namespace BtitUser\Form;

use Zend\Form\Element;

class Register extends Base
{
    public function __construct($name = null)
    {
        
        parent::__construct($name);
        $csrf = new Element\Csrf('registerCsrf');
        $csrf->getCsrfValidator()->setTimeout(600);
        $this->add($csrf);
        $this->get('sbt-user')->setValue('Register');
        $this->getEventManager()->trigger('init', $this);
    }
}
