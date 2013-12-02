<?php
namespace Event\Form;

use Zend\Form\Fieldset;

/**
 * Class OrderRowSeatFieldset
 *
 * @package Event\Form
 */
class OrderRowSeatFieldset extends Fieldset
{
    /**
     *
     */
    public function init()
    {
        $seatsPerRow = range('A', 'T');

        foreach ($seatsPerRow as $seat) {
            $this->add(
                array(
                    'type'    => 'checkbox',
                    'name'    => $seat,
                    'options' => array(
                        'label'              => $seat,
                        'use_hidden_element' => true,
                        'checked_value'      => true,
                        'unchecked_value'    => false,
                    ),
                )
            );
        }
    }
}