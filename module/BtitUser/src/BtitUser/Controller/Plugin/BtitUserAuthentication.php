<?php

namespace BtitUser\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;
use BtitUser\Authentication\Adapter\AdapterChain as AuthAdapter;

class BtitUserAuthentication extends AbstractPlugin
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

   
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    
    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

    
    public function getAuthAdapter()
    {
        return $this->authAdapter;
    }

    
    public function setAuthAdapter(AuthAdapter $authAdapter)
    {
        $this->authAdapter = $authAdapter;
        return $this;
    }

    
    public function getAuthService()
    {
        return $this->authService;
    }

   
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }

}
