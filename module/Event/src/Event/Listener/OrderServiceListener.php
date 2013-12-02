<?php
namespace Event\Listener;

use Event\Entity\OrderEntity;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\File;
use Zend\Mail\Transport\FileOptions;

/**
 * Class OrderServiceListener
 *
 * @package Event\Listener
 */
class OrderServiceListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            'postOrderInsert', array($this, 'sendOrderConfirmation')
        );
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $key => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$key]);
            }
        }
    }

    /**
     * @param EventInterface $e
     */
    public function sendOrderConfirmation(EventInterface $e)
    {
        /* @var $order OrderEntity */
        $order = $e->getParam('order');

        $body = "Ihre Bestellung ist eingegangen.\n\n";
        $body .= "Sie können Sie hier anschauen und ändern:\n";
        $body .= "http://php-summit.zf2/event/order/show/" . $order->getEvent()
            . "/" . $order->getId() . "\n";

        $mail = new Message();
        $mail->setFrom('events@ralfeggert.de', 'Event');
        $mail->addTo($order->getEmail(), $order->getName());
        $mail->setSubject('Bestellung eingegangen');
        $mail->setBody($body);

        $transport = new File();
        $options   = new FileOptions(array(
            'path'     => APPLICATION_ROOT . '/data/mail/',
            'callback' => function (File $transport) {
                    return
                        'Message_' . microtime(true) . '_' . mt_rand() . '.txt';
                },
        ));
        $transport->setOptions($options);
        $transport->send($mail);
    }

}