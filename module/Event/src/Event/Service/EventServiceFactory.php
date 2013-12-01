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
        $inputFilterManager = $serviceLocator->get('InputFilterManager');

        $table    = $serviceLocator->get('Event\Table\Event');
        $entity   = $serviceLocator->get('Event\Entity\Event');
        $hydrator = $hydratorManager->get('Event\Hydrator');
        $filter   = $inputFilterManager->get('Event\Filter');

        $service = new EventService($entity, $table, $hydrator, $filter);

        return $service;
    }

} 