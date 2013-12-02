<?php

namespace Event\Controller;

use Event\Form\OrderForm;
use Event\Service\EventService;
use Event\Service\OrderService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class OrderController
 *
 * @package Event\Controller
 */
class OrderController extends AbstractActionController
{
    /**
     * @var EventService
     */
    protected $eventService;
    /**
     * @var OrderForm
     */
    protected $orderForm;
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @return ViewModel
     */
    public function bookAction()
    {
        $id = (int)$this->params()->fromRoute('id');

        $event = $this->getEventService()->fetchEventEntity($id);

        if (!$event) {
            $this->flashMessenger()->addErrorMessage('Unbekanntes Event');

            return $this->redirect()->toRoute('event-admin');
        }

        $orderForm = $this->getOrderForm();

        if ($this->getRequest()->isPost()) {
            $entity = $this->getOrderService()->save(
                $this->getRequest()->getPost()->toArray()
            );

            \Zend\Debug\Debug::dump($entity);
            \Zend\Debug\Debug::dump($this->getOrderService()->getFilter()->getValues());
            \Zend\Debug\Debug::dump($this->getOrderService()->getFilter()->getMessages());

            if ($entity) {
                return $this->redirect()->toRoute(
                    'event-order/action',
                    array('action' => 'saved', 'id' => $entity->getId())
                );
            }

            $orderForm->setData(
                $this->getOrderService()->getFilter()->getValues()
            );

            $orderForm->setMessages(
                $this->getOrderService()->getFilter()->getMessages()
            );
        }

        return new ViewModel(
            array(
                'event'     => $event,
                'orderForm' => $orderForm,
            )
        );
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
     * @return \Event\Form\OrderForm
     */
    public function getOrderForm()
    {
        return $this->orderForm;
    }

    /**
     * @param \Event\Form\OrderForm $orderForm
     */
    public function setOrderForm($orderForm)
    {
        $this->orderForm = $orderForm;
    }

    /**
     * @return \Event\Service\OrderService
     */
    public function getOrderService()
    {
        return $this->orderService;
    }

    /**
     * @param \Event\Service\OrderService $orderService
     */
    public function setOrderService($orderService)
    {
        $this->orderService = $orderService;
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
}

