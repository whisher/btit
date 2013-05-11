<?php
namespace BtitBase\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BaseController extends AbstractActionController
{
    public function indexAction()
    {
        $view =  new ViewModel(); 
        return $view;
    }
    
    
}
