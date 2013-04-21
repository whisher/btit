<?php
namespace BtitUser;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\NoRecordExists;
class Module
{
    

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
                'btitUserAuthentication' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $authService = $serviceLocator->get('btituser_auth_service');
                    $authAdapter = $serviceLocator->get('btituser_auth_adapter_chain');
                    $controllerPlugin = new Controller\Plugin\BtitUserAuthentication;
                    $controllerPlugin->setAuthService($authService);
                    $controllerPlugin->setAuthAdapter($authAdapter);
                    return $controllerPlugin;
                },
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'btituser_auth_storage' => 'BtitUser\Authentication\Storage\Db', 
                'btituser_auth_adapter' => 'BtitUser\Authentication\Adapter\Db',
                'btituser_user_service'              => 'BtitUser\Service\User',
                'btituser_register_form_hydrator'    => 'Zend\Stdlib\Hydrator\ClassMethods',
            ),
            'factories' => array(
               'btituser_auth_service' => function ($sm) {
                    return new \Zend\Authentication\AuthenticationService(
                        $sm->get('btituser_auth_storage'),
                        $sm->get('btituser_auth_adapter_chain')
                    );
                },
               'btituser_auth_adapter_chain' => 'BtitUser\Authentication\Adapter\AdapterChainServiceFactory',
               'btituser_login_form' => function($sm) {
                    $options = $sm->get('zfcuser_module_options');
                    $form = new Form\Login(null, $options);
                    $form->setInputFilter(new Form\LoginFilter($options));
                    return $form;
                },
               'btituser_form_register' => function ($sm) {
                    $form = new Form\Register('frm-register');
                    $form->setInputFilter(new Form\RegisterFilter(
                        new NoRecordExists(array(
                            'adapter'=>$sm->get('Zend\Db\Adapter\Adapter'),
                            'table' => 'user',
                            'field'    => 'email'
                        ))
                    ));
                    return $form;
                },
                'btituser_user_mapper' => function ($sm) {
                    $tableGateway = $sm->get('btituser_user_table_gateway');
                    return  new Mapper\User($tableGateway);
                    
                }, 
                'btituser_user_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $hydrator  = $sm->get('btituser_user_hydrator');
                    $rowObjectPrototype = new Entity\User();
                    $resultSet  = new HydratingResultSet($hydrator, $rowObjectPrototype);
                    return new TableGateway('user',$dbAdapter,null,$resultSet);
                }, 
                'btituser_user_hydrator' => function ($sm) {
                    $hydrator = new Mapper\UserHydrator();
                    return $hydrator;
                },
            ),
        );
    }
}
