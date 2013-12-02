<?php

namespace Event\Controller;

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
    protected $eventService = null;
    /**
     * @var OrderForm
     */
    protected $orderForm = null;
    /**
     * @var OrderService
     */
    protected $orderService = null;

    /**
     * @return ViewModel
     */
    public function bookAction()
    {
        $eventId = (int)$this->params()->fromRoute('id');

        $event = $this->getEventService()->fetchEventEntity($eventId);

        if (!$event) {
            $this->flashMessenger()->addErrorMessage('Unbekanntes Event');

            return $this->redirect()->toRoute('event-admin');
        }

        $orderForm = $this->getOrderForm();

        if ($this->getRequest()->isPost()) {
            $postData          = $this->getRequest()->getPost()->toArray();
            $postData['event'] = $eventId;

            $order = $this->getOrderService()->save($postData);

            if ($order) {
                $this->flashMessenger()->addSuccessMessage(
                    'Ihre Bestellung wurde gespeichert!'
                );

                return $this->redirect()->toRoute(
                    'event-order/action',
                    array(
                        'action' => 'show', 'id' => $eventId,
                        'order'  => $order->getId()
                    )
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

    public function showAction()
    {
        $orderId = $this->params()->fromRoute('order');

        $order = $this->getOrderService()->fetchOrderEntity($orderId);

        if (!$order) {
            $this->flashMessenger()->addErrorMessage('Unbekannte Bestellung!');

            return $this->redirect()->toRoute('event-order');
        }

        $event = $this->getEventService()->fetchEventEntity($order->getEvent());

        return new ViewModel(
            array(
                'order' => $order,
                'event' => $event,
            )
        );
    }


}

