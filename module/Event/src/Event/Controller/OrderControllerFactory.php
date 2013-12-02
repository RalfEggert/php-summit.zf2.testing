<?php
namespace Event\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OrderControllerFactory
 *
 * @package Event\Controller
 */
class OrderControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerLoader
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        $serviceLocator     = $controllerLoader->getServiceLocator();
        $formElementManager = $serviceLocator->get('FormElementManager');

        $eventService = $serviceLocator->get('Event\Service\Event');
        $orderService = $serviceLocator->get('Event\Service\Order');
        $orderForm    = $formElementManager->get('Order\Form');

        $controller = new OrderController();
        $controller->setEventService($eventService);
        $controller->setOrderService($orderService);
        $controller->setOrderForm($orderForm);

        return $controller;
    }
}