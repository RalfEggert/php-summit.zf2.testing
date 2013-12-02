<?php
namespace Event\Form;

use Zend\Form\Fieldset;

/**
 * Class OrderRowFieldset
 *
 * @package Event\Form
 */
class OrderRowFieldset extends Fieldset
{
    /**
     *
     */
    public function init()
    {
        $this->setLabel('Sitzplätze');

        $rows = range(1, 15);

        foreach ($rows as $row) {
            $this->add(
                array(
                    'type'    => 'OrderRowSeatFieldset',
                    'name'    => $row,
                    'options' => array(
                        'label'   => 'Reihe ' .  $row,
                    ),
                )
            );
        }
    }
}