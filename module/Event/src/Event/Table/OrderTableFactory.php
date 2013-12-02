<?php
namespace Event\Table;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OrderTableFactory
 *
 * @package Event\Table
 */
class OrderTableFactory implements FactoryInterface
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
        $entity   = $serviceLocator->get('Event\Entity\Order');
        $hydrator = $hydratorManager->get('Order\Hydrator');

        $resultSetPrototype = new HydratingResultSet($hydrator, $entity);

        $table = new OrderTable($adapter, $resultSetPrototype);

        return $table;
    }

} 