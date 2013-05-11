<?php
namespace BtitAcl;

use Zend\Mvc\MvcEvent,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface;
 
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach('route', array($this, 'loadConfiguration'), 2);
        //you can attach other function need here...
    }
 
    public function loadConfiguration(MvcEvent $e)
    {
        $application   = $e->getApplication();
        $sm            = $application->getServiceManager();
        $sharedManager = $application->getEventManager()->getSharedManager();
        $router = $sm->get('router');
        $request = $sm->get('request');
    $matchedRoute = $router->match($request);
   // \Zend\Debug\Debug::dump($matchedRoute);
   if (null !== $matchedRoute) {
           $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',
                function($e) use ($sm) {
           $url = $sm->get('ControllerPluginManager')->get('btitAclAuthorize')
                      ->doAuthorization($e);   
          
           },2
           );
        }
    }
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
     public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'btitAclAuthorize' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $aclPlugin = new Controller\Plugin\BtitAclAuthorize();
                    return $aclPlugin;
                },
            ),
        );
    }
}
