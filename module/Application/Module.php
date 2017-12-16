<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

use Zend\Session\SessionManager;
use Zend\Session\Container;

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

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        $viewModel = $event->getViewModel();
        $viewModel->myRoute = 'home';

        $application->getEventManager()->attach(
            'dispatch',
            function ($e) {
                $app = $e->getApplication();
                $serviceManager = $app->getServiceManager();

                $sessionContainer = new Container('ContainerNamespace');

                $routeMatch = $e->getRouteMatch();
                $viewModel = $e->getViewModel();

                $routeName = $routeMatch->getMatchedRouteName();
                $viewModel->myRoute = $routeMatch->getMatchedRouteName();

                $request = $e->getRequest();
                $lang = 'pt_BR';
                if (isset($sessionContainer->lang)) {
                    $lang = $sessionContainer->lang;
                }
                if ($request->getQuery('lang') != '') {
                    if (in_array($request->getQuery('lang'), ['pt_BR', 'en_US', 'es_ES'])) {
                        $lang = $request->getQuery('lang');
                    }
                }
                $sessionContainer->lang = $lang;
                $translator = $serviceManager->get(\Zend\I18n\Translator\TranslatorInterface::class);
                $translator->setLocale($lang);
            },
            100
        );
    }
}
