<?php
namespace Event\InputFilter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OrderFilterFactory
 *
 * @package Event\InputFilter
 */
class OrderFilterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $inputFilterManager
     */
    public function createService(ServiceLocatorInterface $inputFilterManager)
    {
        $serviceLocator = $inputFilterManager->getServiceLocator();

        $config = $serviceLocator->get('Event\Config');

        $inputFilter = new OrderFilter();
        $inputFilter->setStatusHaystack(
            array_keys(
                $config['options']['order_status']
            )
        );

        return $inputFilter;
    }

} 