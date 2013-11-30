<?php
namespace Event\Config;

use Zend\Config\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventConfigFactory
 *
 * @package Event\Config
 */
class EventConfigFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return array|\Zend\Config\Config
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = Factory::fromFile(
            APPLICATION_ROOT . '/module/Event/config/event.config.php'
        );

        return $config;
    }
}