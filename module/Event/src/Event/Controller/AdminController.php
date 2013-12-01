<?php

namespace Event\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
    protected $eventForm = null;
    /**
     * @var EventService
     */
    protected $eventService = null;

    /**
     * @return ViewModel
     */
    public function createAction()
    {
        $eventForm = $this->getEventForm();

        if ($this->getRequest()->isPost()) {
            $entity = $this->getEventService()->save(
                $this->getRequest()->getPost()->toArray()
            );

            if ($entity) {
                return $this->redirect()->toRoute('event-admin');
            }

            $eventForm->setData(
                $this->getEventService()->getFilter()->getValues()
            );

            $eventForm->setMessages(
                $this->getEventService()->getFilter()->getMessages()
            );
        }

        return new ViewModel(
            array(
                'eventForm' => $eventForm,
                'message'   => $this->getEventService()->getMessage(),
            )
        );
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

    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id');

        $event = $this->getEventService()->fetchEventEntity($id);

        if (!$event) {
            $this->flashMessenger()->addErrorMessage('Unbekanntes Event');

            return $this->redirect()->toRoute('event-admin');
        }

        $eventForm = $this->getEventForm();

        if ($this->getRequest()->isPost()) {
            $entity = $this->getEventService()->save(
                $this->getRequest()->getPost()->toArray(),
                $id
            );

            if ($entity) {
                return $this->redirect()->toRoute(
                    'event-admin/action',
                    array('action' => 'update', 'id' => $entity->getId())
                );
            }

            $eventForm->setData(
                $this->getEventService()->getFilter()->getValues()
            );

            $eventForm->setMessages(
                $this->getEventService()->getFilter()->getMessages()
            );
        } else {
            $eventForm->setData(
                $this->getEventService()->getHydrator()->extract($event)
            );
        }

        return new ViewModel(
            array(
                'event'     => $event,
                'eventForm' => $eventForm,
                'message'   => $this->getEventService()->getMessage(),
            )
        );
    }


}

