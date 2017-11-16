<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    const VERSION = '3.0.3-dev';
    public function getAutoloaderConfig()
    {
         return [
             'Zend\Loader\StandardAutoloader' => [
                 'namespaces' => [
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ],
             ],
         ];
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $app->getEventManager()->attach(
            'dispatch',
            function ($e) {
                $request = $e->getRequest();
                if ($request->getQuery('lang') != '') {
                    $serviceManager = $e->getApplication()->getServiceManager();
                    $translator = $serviceManager->get(\Zend\I18n\Translator\TranslatorInterface::class);
                    $translator->setLocale($request->getQuery('lang'));
                }
            },
            100
        );
    }
}
