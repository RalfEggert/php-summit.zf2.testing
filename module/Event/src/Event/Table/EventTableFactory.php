<?php
namespace Event\Table;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventTableFactory
 *
 * @package Event\Table
 */
class EventTableFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EventTable
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydratorManager = $serviceLocator->get('HydratorManager');

        $adapter  = $serviceLocator->get('Zend\Db\Adapter\Sqlite');
        $entity   = $serviceLocator->get('Event\Entity\Event');
        $hydrator = $hydratorManager->get('Event\Hydrator');

        $resultSetPrototype = new HydratingResultSet($hydrator, $entity);

        $table = new EventTable($adapter, $resultSetPrototype);

        return $table;
    }

} 