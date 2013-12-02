<?php
namespace Event\Hydrator;

use Zend\Serializer\Serializer;
use Zend\Stdlib\Hydrator\ClassMethods;
use DateTime;

/**
 * Class OrderHydrator
 *
 * @package Event\Hydrator
 */
class OrderHydrator extends ClassMethods
{
    /**
     * @param array  $data
     * @param object $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (isset($data['datetime'])) {
            $data['datetime'] = new DateTime($data['datetime']);
        }

        if (isset($data['seats']) && is_string($data['seats'])) {
            $data['seats'] = Serializer::unserialize($data['seats']);
        }

        return parent::hydrate($data, $object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function extract($object)
    {
        $data = parent::extract($object);

        if (isset($data['datetime']) && $data['datetime'] instanceof DateTime) {
            $data['datetime'] = $data['datetime']->format('Y-m-d H:i:s');
        }

        if (isset($data['seats']) && is_array($data['seats'])) {
            $data['seats'] = Serializer::serialize($data['seats']);
        }

        return $data;
    }
}