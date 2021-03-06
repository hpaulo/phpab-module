<?php
/**
 * This file is part of phpab/phpab-module. (https://github.com/phpab/phpab-module)
 *
 * @link https://github.com/phpab/phpab-module for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpab. (https://github.com/phpab/)
 * @license https://raw.githubusercontent.com/phpab/phpab-module/master/LICENSE MIT
 */

namespace PhpAbModule;

use PhpAb\Engine\EngineInterface;
use Zend\ModuleManager\Listener\ServiceListener;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * The Module class which is used to be loaded into a Zend Framework 2 application.
 */
class Module
{
    /**
     * Gets the configuration for this module.
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Initializes the module.
     *
     * @param ModuleManagerInterface $moduleManager
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'onLoadModulesPost'));
    }

    /**
     * Called when the modules are loaded.
     *
     * @param ModuleEvent $event
     */
    public function onLoadModulesPost(ModuleEvent $event)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $event->getParam('ServiceManager');

        /** @var EngineInterface $engine */
        $engine = $serviceManager->get('phpab.engine');
        $engine->start();
    }
}
