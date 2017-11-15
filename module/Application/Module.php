<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

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
}