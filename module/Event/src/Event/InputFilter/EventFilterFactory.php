<?php
namespace Event\InputFilter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventFilterFactory
 *
 * @package Event\InputFilter
 */
class EventFilterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $inputFilterManager
     */
    public function createService(ServiceLocatorInterface $inputFilterManager)
    {
        $serviceLocator = $inputFilterManager->getServiceLocator();

        $config = $serviceLocator->get('Event\Config');

        $inputFilter = new EventFilter();
        $inputFilter->setStatusHaystack(
            array_keys(
                $config['options']['status']
            )
        );

        return $inputFilter;
    }

} 