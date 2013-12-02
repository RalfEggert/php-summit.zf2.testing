<?php
namespace Event\Service;

use Event\Entity\OrderEntity;
use Event\Hydrator\OrderHydrator;
use Event\InputFilter\OrderFilter;
use Event\Table\OrderTable;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\EventManager\EventManager;
use Zend\Math\Rand;

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
     * @var EventManager
     */
    protected $eventManager;
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
     * @return string
     */
    public function createPrimaryKey()
    {
        do {
            $newId = Rand::getString(8, '0123456789abcdefABCDEF', true);

            $order = $this->fetchOrderEntity($newId);
        } while ($order !== false);

        return $newId;
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
     * @return array
     */
    public function fetchBookedSeatsByEvent($event)
    {
        /* @var $order OrderEntity */
        $bookedSeats = array();

        foreach ($this->getTable()->fetchManyByEvent($event) as $order) {
            foreach ($order->getSeats() as $row => $rowData) {
                if (!isset($bookedSeats[$row])) {
                    $bookedSeats[$row] = array();
                }
                foreach ($rowData as $seat => $seatData) {
                    if (!isset($bookedSeats[$row][$seat])) {
                        $bookedSeats[$row][$seat] = 0;
                    }
                    $bookedSeats[$row][$seat] += $seatData;
                }
            }
        }

        return $bookedSeats;
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
     * @return \Zend\EventManager\EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @param \Zend\EventManager\EventManager $eventManager
     */
    public function setEventManager($eventManager)
    {
        $eventManager->addIdentifiers(array(__CLASS__));

        $this->eventManager = $eventManager;
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

        if ($mode == 'insert') {
            $newId = $this->createPrimaryKey();

            $entity->setId($newId);
            $entity->setDatetime(new \DateTime());
            $entity->setCount(0);
            $entity->setStatus(1);
        }

        $saveData = $this->getHydrator()->extract($entity);

        try {
            if ($mode == 'insert') {
                $this->getTable()->insert($saveData);
                $id = $newId;
            } else {
                $this->getTable()->update($saveData, array('id' => $id));
            }
        } catch (InvalidQueryException $e) {
            $this->setMessage('Order konnte nicht gespeichert werden!');

            return false;
        }

        $entity = $this->fetchOrderEntity($id);

        if ($mode == 'insert') {
            $result = $this->getEventManager()->trigger(
                'postOrderInsert', __CLASS__, array('order' => $entity)
            );
        }

        return $entity;
    }
}