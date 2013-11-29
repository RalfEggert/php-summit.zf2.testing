<?php
namespace Event\Controller;

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
     * @var array
     */
    protected $eventList = array();

    /**
     *
     */
    public function __construct()
    {
        $this->eventList = array(
            123 => array(
                'id'          => '123',
                'name'        => 'Fettes Brot Konzert',
                'description' => 'Fettes Konzert mit den Broten',
                'date'        => new \DateTime('2013-12-06'),
                'time'        => new \DateTime('20:00:00'),
                'status'      => 1,
            ),
            456 => array(
                'id'          => '456',
                'name'        => 'Malen nach Zahlen',
                'description' => 'Das Mitmach-Event für die ganze Familie',
                'date'        => new \DateTime('2013-12-12'),
                'time'        => new \DateTime('15:00:00'),
                'status'      => 2,
            ),
        );
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            array(
                'eventList' => $this->eventList,
            )
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function showAction()
    {
        $id = (int)$this->params()->fromRoute('id');

        if (!isset($this->eventList[$id])) {
            $this->flashMessenger()->addErrorMessage('Unbekanntes Event');

            return $this->redirect()->toRoute('event-admin');
        }

        return new ViewModel(
            array(
                'event' => $this->eventList[$id],
            )
        );
    }

    /**
     * @return \Zend\Http\Response
     */
    public function createAction()
    {
        /* @var $eventService EventService */
        $eventService = $this->getServiceLocator()->get('Event\Service\Event');

        foreach ($this->eventList as $eventData) {
            $eventData['date'] = $eventData['date']->format('Y-m-d');
            $eventData['time'] = $eventData['time']->format('H:i:s');

            $eventService->save($eventData);
        }

        return $this->redirect()->toRoute('event-admin');
    }
}

