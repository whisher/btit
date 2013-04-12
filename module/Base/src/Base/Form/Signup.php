<?php

namespace Base\Form;

class Signup extends Base
{
    public function __construct($name = null)
    {
        
        parent::__construct($name);
        $this->remove('repassword');
        $this->get('sbt-signup')->setValue('Register');
        $this->getEventManager()->trigger('init', $this);
    }
}
