<?php
namespace BtitUser\Mapper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BtitBase\EventManager\EventProvider;

abstract class AbstractDbMapper extends EventProvider implements ServiceLocatorAwareInterface {
    
    protected $serviceManager;
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceManager;
    }
    
}