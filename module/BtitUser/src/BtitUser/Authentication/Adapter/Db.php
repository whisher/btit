<?php

namespace BtitUser\Authentication\Adapter;

use DateTime;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Crypt\Password\Bcrypt;
use BtitUser\Authentication\Adapter\AdapterChainEvent as AuthEvent;
use BtitUser\Mapper\User as UserMapperInterface;

class Db extends AbstractAdapter implements ServiceManagerAwareInterface
{
    const COST = 14;
    
    protected $mapper;
    protected $serviceManager;
    protected $credentialsOptions = array('username','email');
    protected $notAllowedState = array('2'=>'A record with the supplied identity is not active.');
    
    public function authenticate(AuthEvent $e)
    {
        if ($this->isSatisfied()) {
            $storage = $this->getStorage()->read();
            $e->setIdentity($storage['identity'])
              ->setCode(AuthenticationResult::SUCCESS)
              ->setMessages(array('Authentication successful.'));
            return;
        }

        $identity   = $e->getRequest()->getPost()->get('identity');
        $credential = $e->getRequest()->getPost()->get('credential');
        $userObject = NULL;

        $fields = $this->credentialsOptions;
        while ( !is_object($userObject) && count($fields) > 0 ) {
            $mode = array_shift($fields);
            switch ($mode) {
                case 'username':
                    $userObject = $this->getMapper()->findByUsername($identity);
                    break;
                case 'email':
                    $userObject = $this->getMapper()->findByEmail($identity);
                    break;
            }
        }

        if (!$userObject) {
            $e->setCode(AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND)
              ->setMessages(array('A record with the supplied identity could not be found.'));
            $this->setSatisfied(false);
            return false;
        }

        // Don't allow user to login if state is not in allowed list
        if (in_array($userObject->getState(), array_keys($this->notAllowedState))) {
            $e->setCode(AuthenticationResult::FAILURE_UNCATEGORIZED)
            ->setMessages(array($this->notAllowedState[$userObject->getState()]));
            $this->setSatisfied(false);
            return false;
        }
        
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(static::COST);
        if (!$bcrypt->verify($credential,$userObject->getPassword())) {
            // Password does not match
            $e->setCode(AuthenticationResult::FAILURE_CREDENTIAL_INVALID)
              ->setMessages(array('Supplied credential is invalid.'));
            $this->setSatisfied(false);
            return false;
        }

        // Success!
        $e->setIdentity($userObject->getId());
        $this->setSatisfied(true);
        $storage = $this->getStorage()->read();
        $storage['identity'] = $e->getIdentity();
        $this->getStorage()->write($storage);
        $e->setCode(AuthenticationResult::SUCCESS)
          ->setMessages(array('Authentication successful.'));
    }

    

    public function getMapper()
    {
        if (null === $this->mapper) {
            $this->setMapper($this->getServiceManager()->get('btituser_user_mapper'));
        }
        return $this->mapper;
    }

    protected function setMapper(UserMapperInterface $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    
}
