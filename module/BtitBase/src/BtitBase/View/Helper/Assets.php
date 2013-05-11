<?php
namespace BtitBase\View\Helper;
 
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 


class Assets extends AbstractHelper
{

    protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function __invoke()
    {
       // $controller = $this->routeMatch->routeMatch();
        if(isset($this->routeMatch)){
        //var_dump($this->routeMatch->getMatchedRouteName());
        //var_dump($this->routeMatch->getParam('controller'));
        //var_dump($this->routeMatch->getParam('action'));
        return $this->getView()->headLink()->prependStylesheet('/res/pippo.css');
        }
    }
}