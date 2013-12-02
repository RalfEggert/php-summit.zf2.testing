<?php
namespace Application\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\I18n\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

/**
 * Class I18nListener
 *
 * @package Application\Listener
 */
class I18nListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @param EventInterface $e
     */
    public function addValidatorTranslations(EventInterface $e)
    {
        $translator = $e->getTarget()->getServiceManager()->get('translator');

        AbstractValidator::setDefaultTranslator($translator, 'default');
    }

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
            MvcEvent::EVENT_ROUTE, array($this, 'setupLocale'), -100
        );
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH, array($this, 'addValidatorTranslations'),
            100
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
    public function setupLocale(EventInterface $e)
    {
        \Locale::setDefault('de');
    }

}