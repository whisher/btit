<?php
namespace BtitUser\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;

class UserHydrator extends ClassMethods
{
   
    public function extract($object)
    {
        return parent::extract($object);
    }

    public function hydrate(array $data, $object)
    {
        return parent::hydrate($data, $object);
    }

    
}
