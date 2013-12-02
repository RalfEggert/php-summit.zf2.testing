<?php
namespace Event\Service;

use Event\Entity\OrderEntity;
use Event\Hydrator\OrderHydrator;
use Event\InputFilter\OrderFilter;
use Event\Table\OrderTable;
use Zend\Db\Adapter\Exception\InvalidQueryException;

/**
 * Class OrderService
 *
 * @package Event\Service
 */
class OrderService
{

    /**
     * @var OrderEntity
     */
    protected $entity;
    /**
     * @var OrderFilter
     */
    protected $filter;
    /**
     * @var OrderHydrator
     */
    protected $hydrator;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var OrderTable
     */
    protected $table;

    /**
     * @param OrderEntity $entity
     * @param OrderTable  $table
     */
    function __construct(
        OrderEntity $entity, OrderTable $table, OrderHydrator $hydrator,
        OrderFilter $filter
    ) {
        $this->entity   = $entity;
        $this->table    = $table;
        $this->hydrator = $hydrator;
        $this->filter   = $filter;
    }

    /**
     * @param null $id
     *
     * @return bool
     */
    public function delete($id = null)
    {
        try {
            $this->getTable()->delete(array('id' => $id));
        } catch (InvalidQueryException $e) {
            $this->setMessage('Order konnte nicht gelöscht werden!');

            return false;
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return OrderEntity
     */
    public function fetchOrderEntity($id)
    {
        return $this->getTable()->fetchSingleById($id);
    }

    /**
     * @return array
     */
    public function fetchOrderList()
    {
        $eventList = array();

        foreach ($this->getTable()->fetchMany() as $entity) {
            $eventList[] = $entity;
        }

        return $eventList;
    }

    /**
     * @return OrderEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param OrderEntity $entity
     */
    public function setEntity(OrderEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Order\InputFilter\OrderFilter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param \Order\InputFilter\OrderFilter $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return OrderHydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * @param OrderHydrator $hydrator
     */
    public function setHydrator(OrderHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return OrderTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param OrderTable $table
     */
    public function setTable(OrderTable $table)
    {
        $this->table = $table;
    }

    /**
     * @param array $data
     * @param null  $id
     *
     * @return bool|OrderEntity
     */
    public function save(array $data, $id = null)
    {
        $mode = $id ? 'update' : 'insert';

        $entity = $mode == 'insert'
            ? clone $this->getEntity()
            : $this->fetchOrderEntity($id);

        $this->getFilter()->setData($data);

        if (!$this->getFilter()->isValid()) {
            $this->setMessage('Bitte Eingaben überprüfen!');

            return false;
        }

        $this->getHydrator()->hydrate($data, $entity);

        $saveData = $this->getHydrator()->extract($entity);

        try {
            if ($mode == 'insert') {
                $this->getTable()->insert($saveData);
                $id = $this->getTable()->getLastInsertValue();
            } else {
                $this->getTable()->update($saveData, array('id' => $id));
            }
        } catch (InvalidQueryException $e) {
            $this->setMessage('Order konnte nicht gespeichert werden!');

            return false;
        }

        return $this->fetchOrderEntity($id);
    }
}