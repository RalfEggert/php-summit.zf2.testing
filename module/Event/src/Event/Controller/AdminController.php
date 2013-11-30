<?php
namespace Event\Controller;

use Event\InputFilter\EventFilter;
use Event\Service\EventService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ArrayObject;
use Zend\View\Model\ViewModel;

/**
 * Class AdminController
 *
 * @package Event\Controller
 */
class AdminController extends AbstractActionController
{
    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * @param \Event\Service\EventService $eventService
     */
    public function setEventService($eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @return \Event\Service\EventService
     */
    public function getEventService()
    {
        return $this->eventService;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            array(
                'eventList' => $this->getEventService()->fetchEventList(),
            )
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $event = $this->getEventService()->fetchEventEntity($id);

        if (!$event) {
            $this->flashMessenger()->addErrorMessage('Unbekanntes Event');

            return $this->redirect()->toRoute('event-admin');
        }

        return new ViewModel(
            array(
                'event' => $event,
            )
        );
    }

    /**
     * @return \Zend\Http\Response
     */
    public function createAction()
    {

    }
}

