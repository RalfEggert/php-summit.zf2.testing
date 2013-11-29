<?php
namespace Event\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventServiceFactory
 *
 * @package Event\Service
 */
class EventServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EventService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydratorManager = $serviceLocator->get('HydratorManager');

        $table    = $serviceLocator->get('Event\Table\Event');
        $entity   = $serviceLocator->get('Event\Entity\Event');
        $hydrator = $hydratorManager->get('Event\Hydrator');

        $service = new EventService($entity, $table, $hydrator);

        return $service;
    }

} 