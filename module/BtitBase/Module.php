<?php
namespace BtitBase;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'btitbase_configs' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Configs\ModuleConfigs($config['base']);
                }
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'ogMetaTags' => function($sm) {
                    $locator = $sm->getServiceLocator(); 
                    return new View\Helper\OgMetaTags($sm->getServiceLocator()->get('btitbase_configs')->getFb());
                },
                'settings' => function($sm) {
                    $locator = $sm->getServiceLocator(); 
                    return new View\Helper\Settings($sm->getServiceLocator()->get('btitbase_configs'));
                },
                'absoluteUrl' => function($sm) {
                    $locator = $sm->getServiceLocator(); 
                    return new View\Helper\AbsoluteUrl($locator->get('Request'));
                },
            ),
         );
    }
}
