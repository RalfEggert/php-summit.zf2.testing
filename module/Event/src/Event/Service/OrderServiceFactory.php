<?php
namespace Event\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OrderServiceFactory
 *
 * @package Event\Service
 */
class OrderServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return OrderService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydratorManager = $serviceLocator->get('HydratorManager');
        $inputFilterManager = $serviceLocator->get('InputFilterManager');

        $table    = $serviceLocator->get('Event\Table\Order');
        $entity   = $serviceLocator->get('Event\Entity\Order');
        $hydrator = $hydratorManager->get('Order\Hydrator');
        $filter   = $inputFilterManager->get('Order\Filter');

        $service = new OrderService($entity, $table, $hydrator, $filter);

        return $service;
    }
}
