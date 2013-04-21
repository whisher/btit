<?php
namespace BtitUser\Authentication\Adapter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BtitUser\Authentication\Adapter\AdapterChain;


class AdapterChainServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $chain = new AdapterChain();
        $adapter = $serviceLocator->get('btituser_auth_adapter');
        if(is_callable(array($adapter, 'authenticate'))) {
                $chain->getEventManager()->attach('authenticate', array($adapter, 'authenticate'), 1);
        }
        if(is_callable(array($adapter, 'logout'))) {
                $chain->getEventManager()->attach('logout', array($adapter, 'logout'), 1);
        }
        return $chain;
    }


   

}