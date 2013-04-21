<?php
namespace BtitUser\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Crypt\Password\Bcrypt;
use Zend\Stdlib\Hydrator;
use BtitBase\EventManager\EventProvider;
use BtitUser\Entity\User as EntityUser;
use BtitUser\Mapper\User as UserMapper;

class User extends EventProvider implements ServiceManagerAwareInterface
{

    
    protected $userMapper;

   
    protected $authService;

    
    protected $loginForm;

   
    protected $registerForm;

    
    protected $changePasswordForm;

    
    protected $serviceManager;

    

   protected $formHydrator;

    /**
     * createFromForm
     *
     * @param array $data
     * @return \ZfcUser\Entity\UserInterface
     * @throws Exception\InvalidArgumentException
     */
    public function register(array $data)
    {
       
        $user  = new EntityUser();
        $form  = $this->getRegisterForm();
        $form->setHydrator($this->getFormHydrator());
        $form->bind($user);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }
        $user = $form->getData();
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        $user->setPassword($bcrypt->create($user->getPassword()));
        $user->setDisplayName($user->getFirstname().' '.$user->getSurname());
        $user->setState(0);
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $user, 'form' => $form));
        $this->getUserMapper()->insert($user);
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('user' => $user, 'form' => $form));
        return $user;
    }

    /**
     * change the current users password
     *
     * @param array $data
     * @return boolean
     */
    public function changePassword(array $data)
    {
        $currentUser = $this->getAuthService()->getIdentity();

        $oldPass = $data['credential'];
        $newPass = $data['newCredential'];

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getOptions()->getPasswordCost());

        if (!$bcrypt->verify($oldPass, $currentUser->getPassword())) {
            return false;
        }

        $pass = $bcrypt->create($newPass);
        $currentUser->setPassword($pass);

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));
        $this->getUserMapper()->update($currentUser);
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('user' => $currentUser));

        return true;
    }

    public function changeEmail(array $data)
    {
        $currentUser = $this->getAuthService()->getIdentity();

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getOptions()->getPasswordCost());

        if (!$bcrypt->verify($data['credential'], $currentUser->getPassword())) {
            return false;
        }

        $currentUser->setEmail($data['newIdentity']);

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));
        $this->getUserMapper()->update($currentUser);
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('user' => $currentUser));

        return true;
    }

    /**
     * getUserMapper
     *
     * @return UserMapperInterface
     */
    public function getUserMapper()
    {
        if (null === $this->userMapper) {
            $this->userMapper = $this->getServiceManager()->get('btituser_user_mapper');
        }
        return $this->userMapper;
    }

    
    public function getAuthService()
    {
        if (null === $this->authService) {
            $this->authService = $this->getServiceManager()->get('btituser_auth_service');
        }
        return $this->authService;
    }

    
    public function getRegisterForm()
    {
        if (null === $this->registerForm) {
            $this->registerForm = $this->getServiceManager()->get('btituser_form_register');
        }
        return $this->registerForm;
    }

    /**
     * @return Form
     */
    public function getChangePasswordForm()
    {
        if (null === $this->changePasswordForm) {
            $this->changePasswordForm = $this->getServiceManager()->get('zfcuser_change_password_form');
        }
        return $this->changePasswordForm;
    }

    /**
     * @param Form $changePasswordForm
     * @return User
     */
    public function setChangePasswordForm(Form $changePasswordForm)
    {
        $this->changePasswordForm = $changePasswordForm;
        return $this;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

     public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    
    public function getFormHydrator()
    {
        if (!$this->formHydrator instanceof Hydrator\ClassMethods) {
            $this->setFormHydrator($this->getServiceManager()->get('btituser_register_form_hydrator'));
        }
        return $this->formHydrator;
    }

    
    public function setFormHydrator(Hydrator\ClassMethods $formHydrator)
    {
        $this->formHydrator = $formHydrator;
        return $this;
    }
    
    
}
