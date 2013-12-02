<?php
namespace Event\Table;

use Event\Entity\OrderEntity;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class OrderTable
 *
 * @package Event\Table
 */
class OrderTable extends TableGateway
{
    /**
     * @param AdapterInterface   $adapter
     * @param ResultSetInterface $resultSet
     */
    function __construct(
        AdapterInterface $adapter, ResultSetInterface $resultSet
    ) {
        parent::__construct('orders', $adapter, null, $resultSet);
    }

    /**
     * @return null|ResultSetInterface
     */
    function fetchMany()
    {
        $select = $this->getSql()->select();
        $select->order('datetime DESC');

        return $this->selectWith($select);
    }

    /**
     * @return null|ResultSetInterface
     */
    function fetchManyByEvent($event)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('event', $event);
        $select->order('datetime DESC');

        return $this->selectWith($select);
    }

    /**
     * @param $id
     *
     * @return OrderEntity
     */
    function fetchSingleById($id)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('id', $id);

        return $this->selectWith($select)->current();
    }
}