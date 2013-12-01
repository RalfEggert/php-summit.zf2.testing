<?php
namespace Event\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventFormFactory
 *
 * @package Event\Form
 */
class EventFormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $formElementManager
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $serviceLocator = $formElementManager->getServiceLocator();

        $config = $serviceLocator->get('Event\Config');

        $form = new EventForm();
        $form->setStatusOptions($config['options']['status']);

        return $form;
    }

} 