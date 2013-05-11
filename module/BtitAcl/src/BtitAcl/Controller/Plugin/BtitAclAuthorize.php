<?php

namespace BtitAcl\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
     
class BtitAclAuthorize extends AbstractPlugin
{
    
     
    public function doAuthorization($e)
    { 
        $hasAuthorization = false;
       
        $acl = new Acl();
        
        $acl->addRole(new Role('user'));
        $acl->addRole(new Role('admin'));
       
        
        $acl->addResource(new Resource('BtitBase'));
        $acl->addResource(new Resource('BtitUser'));
        
        
         
        // set up the access rules everybody
        $acl->allow(null, 'BtitBase', array('base:index'));
        $acl->allow(null, 'BtitUser', array('user:register','user:login','user:authenticate'));
 
        //grant the super admin access to everything
        $acl->allow('admin');
        
        $acl->allow('user', 'BtitBase', 'test:index');
         
        
       
        $controller = $e->getTarget();
        $routeMatch = $e->getRouteMatch();
        $controllerClass = get_class($controller);
        $moduleName = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        
        $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name 
        $controllerName = $routeMatch->getParam('controller', 'not-found');
        if(false !== strrpos($controllerName,'_')){
            $chunks = explode('_', $controllerName);
            $controllerName = array_pop($chunks);
        }
        elseif (false !== strrpos($controllerName,'\\')) {
            $chunks = explode('\\', $controllerName);
            $controllerName = array_pop($chunks);
        }
        else{}
        $controllerName = strtolower($controllerName);
        $role = $controller->btitUserAuthentication()->hasIdentity() ? 'user' : null;
       /* var_dump($role);
        var_dump($moduleName);
        var_dump($controllerName.':'.$actionName);
        var_dump( $acl->isAllowed($role, $moduleName, $controllerName.':'.$actionName));
        var_dump($acl->hasResource($moduleName) );
        \Zend\Debug\Debug::dump( $acl->getResources());*/
        if ($acl->hasResource($moduleName) && !$acl->isAllowed($role, $moduleName, $controllerName.':'.$actionName)){
            $router = $e->getRouter();
            $url    = $controller->url()->fromRoute('btituser_route/login');
            $response = $e->getResponse();
            $response->setStatusCode(302);
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();          
        }
        
    }
}