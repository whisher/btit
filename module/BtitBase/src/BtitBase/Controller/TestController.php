<?php
namespace BtitBase\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ResponseInterface as Response;
use BtitBase\Model\User;
use BtitBase\Model\UserTable;

class TestController extends AbstractActionController
{
    public function indexAction()
    {          return new ViewModel();
    }
}
