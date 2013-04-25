<?php
namespace BtitUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Stdlib\Parameters;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;




class UserController extends AbstractActionController
{
   
    const ROUTE_REGISTER     = 'btituser_route/register';
    const ROUTE_LOGIN        = 'btituser_route/login';
    const ROUTE_LOGOUT       = 'btituser_route/login';
    const ROUTE_JUST_LOGGED  = 'btituser_route';
    const CONTROLLER_NAME    = 'btituser_controller';
    
    protected $userService;
    protected $registerForm;
    protected $loginForm;
    protected $failedLoginMessage = 'Authentication failed. Please try again.';
    
    public function indexAction()
    {   
        if (!$this->btitUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
    }
    
    public function registerAction()
    {
        if ($this->btitUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        $request = $this->getRequest();
        $service = $this->getUserService();
        $form = $this->getRegisterForm();
        $redirectUrl = $this->url()->fromRoute(static::ROUTE_REGISTER);
        $prg = $this->prg($redirectUrl, true);
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array('registerForm' => $form);
        }
        $post = $prg;
        $user = $service->register($post);
        if (!$user) {
            return array('registerForm' => $form);
        }
        return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN));
    }
    
    public function loginAction()
    {
        if ($this->btitUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_JUST_LOGGED);
        }
        $request = $this->getRequest();
        
        $form    = $this->getLoginForm();
        if (!$request->isPost()) {
            return array('loginForm' => $form);
        }
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            $this->flashMessenger()->setNamespace('btituser-login-form')->addMessage($this->failedLoginMessage);
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        $this->btitUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->btitUserAuthentication()->getAuthService()->clearIdentity();
        return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
    }

    public function authenticateAction()
    {
        $adapter = $this->btitUserAuthentication()->getAuthAdapter();
        
        $result = $adapter->prepareForAuthentication($this->getRequest());

        // Return early if an adapter returned a response
        if ($result instanceof Response) {
            return $result;
        }

        $auth = $this->btitUserAuthentication()->getAuthService()->authenticate($adapter);

        if (!$auth->isValid()) {
            $this->flashMessenger()->setNamespace('btituser-login-form')->addMessage($this->failedLoginMessage);
            $adapter->resetAdapters();
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }

        

        return $this->redirect()->toRoute(static::ROUTE_JUST_LOGGED);
    }
    
    public function logoutAction()
    {
        $this->btitUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->btitUserAuthentication()->getAuthAdapter()->logoutAdapters();
        $this->btitUserAuthentication()->getAuthService()->clearIdentity();
        return $this->redirect()->toRoute(static::ROUTE_LOGOUT);
    }
    
    public function getRegisterForm()
    {
        if (!$this->registerForm) {
            $this->setRegisterForm($this->getServiceLocator()->get('btituser_form_register'));
        }
        return $this->registerForm;
    }

    public function setRegisterForm(Form $registerForm)
    {
        $this->registerForm = $registerForm;
    }
    
    public function getLoginForm()
    {
        if (!$this->loginForm) {
            $this->setLoginForm($this->getServiceLocator()->get('btituser_login_form'));
        }
        return $this->loginForm;
    }

    public function setLoginForm(Form $loginForm)
    {
        $this->loginForm = $loginForm;
        $fm = $this->flashMessenger()->setNamespace('btituser-login-form')->getMessages();
        if (isset($fm[0])) {
            $this->loginForm->setMessages(
                array('identity' => array($fm[0]))
            );
        }
        return $this;
    }

    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('btituser_user_service');
        }
        return $this->userService;
    }
}
