<?php
namespace Event\Form;

use Zend\Form\Form;

/**
 * Class OrderForm
 *
 * @package Event\Form
 */
class OrderForm extends Form
{
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
                    'label' => 'Ihr Name',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'text',
                'name'    => 'email',
                'options' => array(
                    'label' => 'Ihre E-Mail Adresse',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'text',
                'name'    => 'iban',
                'options' => array(
                    'label' => 'Ihre IBAN',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'text',
                'name'    => 'bic',
                'options' => array(
                    'label' => 'Ihr BIC-Code',
                ),
            )
        );

        $this->add(
            array(
                'type'    => 'OrderRowFieldset',
                'name'    => 'seats',
            )
        );

        $this->add(
            array(
                'type'       => 'submit',
                'name'       => 'save_order',
                'attributes' => array(
                    'value' => 'Buchen',
                    'id'    => 'save_order',
                ),
            )
        );
    }
}