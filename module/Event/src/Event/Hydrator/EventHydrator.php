<?php
namespace Event\Hydrator;

use Zend\Serializer\Serializer;
use Zend\Stdlib\Hydrator\ClassMethods;
use DateTime;

class EventHydrator extends ClassMethods
{
    public function hydrate(array $data, $object)
    {
        if (isset($data['date'])) {
            $data['date'] = new DateTime($data['date']);
        }

        if (isset($data['time'])) {
            $data['time'] = new DateTime($data['time']);
        }

        if (isset($data['seats']) && is_string($data['seats'])) {
            $data['seats'] = Serializer::unserialize($data['seats']);
        }

        return parent::hydrate($data, $object);
    }

    public function extract($object)
    {
        $data = parent::extract($object);

        if (isset($data['date']) && $data['date'] instanceof DateTime) {
            $data['date'] = $data['date']->format('Y-m-d');
        }

        if (isset($data['time']) && $data['time'] instanceof DateTime) {
            $data['time'] = $data['time']->format('H:i');
        }

        if (isset($data['seats']) && is_array($data['seats'])) {
            $data['seats'] = Serializer::serialize($data['seats']);
        }

        return $data;
    }
}