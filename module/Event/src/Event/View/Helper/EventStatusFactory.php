<?php
namespace Event\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventStatusFactory
 *
 * @package Event\View\Helper
 */
class EventStatusFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $viewHelperManager
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        $serviceLocator = $viewHelperManager->getServiceLocator();

        $config = $serviceLocator->get('Event\Config');

        $helper = new EventStatus();
        $helper->setStatusOptions($config['options']['event_status']);

        return $helper;
    }
}