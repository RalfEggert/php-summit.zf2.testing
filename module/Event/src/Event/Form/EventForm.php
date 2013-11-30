<?php
namespace Event\Form;

use Zend\Form\Form;

class EventForm extends Form
{
    public function init()
    {
        $this->add(
            array(
                'type' => 'Csrf',
                'name' => 'csrf',
            )
        );

        $this->add(
            array(
                'type'    => 'text',
                'name'    => 'name',
                'options' => array(
                    'label' => 'Name der Veranstaltung',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'textarea',
                'name'    => 'description',
                'options' => array(
                    'label' => 'Beschreibung',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'date',
                'name'    => 'date',
                'options' => array(
                    'label'  => 'Datum',
                    'format' => 'Y-m-d',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'time',
                'name'    => 'time',
                'options' => array(
                    'label'  => 'Uhrzeit',
                    'format' => 'H:i:s',
                ),
            )
        );
    }
}