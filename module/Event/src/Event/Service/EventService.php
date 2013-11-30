<?php
namespace Event\Service;

use Event\Entity\EventEntity;
use Event\Hydrator\EventHydrator;
use Event\InputFilter\EventFilter;
use Event\Table\EventTable;
use Zend\Db\Adapter\Exception\InvalidQueryException;

/**
 * Class EventService
 *
 * @package Event\Service
 */
class EventService
{

    /**
     * @var EventEntity
     */
    protected $entity;
    /**
     * @var EventFilter
     */
    protected $filter;
    /**
     * @var EventHydrator
     */
    protected $hydrator;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var EventTable
     */
    protected $table;

    /**
     * @param EventEntity   $entity
     * @param EventTable    $table
     * @param EventHydrator $hydrator
     * @param EventFilter   $filter
     */
    function __construct(
        EventEntity $entity, EventTable $table, EventHydrator $hydrator,
        EventFilter $filter
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
            $this->setMessage('Event konnte nicht gelöscht werden!')
            return false;
        }

        return true;
    }

    /**
     * @return EventTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param EventTable $table
     */
    public function setTable(EventTable $table)
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function fetchEventList()
    {
        $eventList = array();

        foreach ($this->getTable()->fetchMany() as $entity) {
            $eventList[] = $entity;
        }

        return $eventList;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param array $data
     * @param null  $id
     *
     * @return bool|EventEntity
     */
    public function save(array $data, $id = null)
    {
        $mode = $id ? 'update' : 'insert';

        $entity = $mode == 'insert'
            ? clone $this->getEntity()
            : $this->fetchEventEntity($id);

        $this->getFilter()->setData($data);

        if (!$this->getFilter()->isValid()) {
            $this->setMessage('Bitte Eingaben überprüfen!')
            return false;
        }

        $this->getHydrator()->hydrate($data, $entity);

        $saveData = $this->getHydrator()->extract($entity);

        try {
            if ($mode == 'insert') {
                $this->getTable()->insert($saveData);
                $id = $this->getTable()->getLastInsertValue();
            } else {
                $this->getTable()->update($saveData, $id);
            }
        } catch (InvalidQueryException $e) {
            $this->setMessage('Event konnte nicht gespeichert werden!')
            return false;
        }

        return $this->fetchEventEntity($id);
    }

    /**
     * @return EventEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param EventEntity $entity
     */
    public function setEntity(EventEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param $id
     *
     * @return EventEntity
     */
    public function fetchEventEntity($id)
    {
        return $this->getTable()->fetchSingleById($id);
    }

    /**
     * @return \Event\InputFilter\EventFilter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param \Event\InputFilter\EventFilter $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return EventHydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * @param EventHydrator $hydrator
     */
    public function setHydrator(EventHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }
}