<?php
namespace Event\Controller;

use Event\Form\EventForm;
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
     * @var EventForm
     */
    protected $eventForm;
    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * @return \Zend\Http\Response
     */
    public function createAction()
    {

    }

    /**
     * @return \Event\Form\EventForm
     */
    public function getEventForm()
    {
        return $this->eventForm;
    }

    /**
     * @param \Event\Form\EventForm $eventForm
     */
    public function setEventForm($eventForm)
    {
        $this->eventForm = $eventForm;
    }

    /**
     * @return \Event\Service\EventService
     */
    public function getEventService()
    {
        return $this->eventService;
    }

    /**
     * @param \Event\Service\EventService $eventService
     */
    public function setEventService($eventService)
    {
        $this->eventService = $eventService;
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
        $id = (int)$this->params()->fromRoute('id');

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
}

