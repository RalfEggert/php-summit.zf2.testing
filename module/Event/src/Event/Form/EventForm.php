<?php
namespace Event\Form;

use Zend\Form\Form;

/**
 * Class EventForm
 *
 * @package Event\Form
 */
class EventForm extends Form
{
    /**
     * @var array
     */
    protected $statusOptions = array();

    /**
     * @return array
     */
    public function getStatusOptions()
    {
        return $this->statusOptions;
    }

    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions)
    {
        $this->statusOptions = $statusOptions;
    }

    /**
     *
     */
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

        $this->add(
            array(
                'type'    => 'select',
                'name'    => 'status',
                'options' => array(
                    'label'         => 'Status',
                    'value_options' => $this->getStatusOptions(),
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'submit',
                'name'       => 'save_event',
                'attributes' => array(
                    'value' => 'Speichern',
                    'id'    => 'save_event',
                ),
            )
        );
    }
}