<?php
namespace Event\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AdminControllerFactory
 *
 * @package Event\Controller
 */
class AdminControllerFactory implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerLoader
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        $serviceLocator = $controllerLoader->getServiceLocator();

        $service = $serviceLocator->get('Event\Service\Event');

        $controller = new AdminController();
        $controller->setEventService($service);

        return $controller;
    }

} 