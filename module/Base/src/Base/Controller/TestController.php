<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class TestController extends AbstractActionController
{
    protected $signUpForm;
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function signupAction()
    {
        $request = $this->getRequest();
        $form = $this->getSignUpForm();
        return array('form' => $form);
    }
    
    public function signupprocessAction()
    {
        return new ViewModel();
    }
    
    public function getSignUpForm()
    {
        if (!$this->signUpForm) {
            $this->setSignUpForm($this->getServiceLocator()->get('base_form_signup'));
        }
        return $this->signUpForm;
    }

    public function setSignUpForm(Form $signupForm)
    {
        $this->signUpForm = $signupForm;
    }
}
