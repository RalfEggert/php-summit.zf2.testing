<?php
namespace Event\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Class EventFilter
 *
 * @package Event\InputFilter
 */
class EventFilter extends InputFilter
{
    /**
     * @var array
     */
    protected $statusHaystack = array();

    /**
     * @return array
     */
    public function getStatusHaystack()
    {
        return $this->statusHaystack;
    }

    /**
     * @param array $statusHaystack
     */
    public function setStatusHaystack($statusHaystack)
    {
        $this->statusHaystack = $statusHaystack;
    }

    /**
     *
     */
    public function init()
    {
        $this->add(
            array(
                'name' => 'id',
            )
        );

        $this->add(
            array(
                'name'       => 'name',
                'required'   => true,
                'filters'    => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min'     => '3',
                            'max'     => '64',
                            'message' => 'Der Name muss zwischen %min% und '
                                . '%max% Zeichen lang sein!',
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'     => 'description',
                'required' => true,
                'filters'  => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'date',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'Date',
                        'options' => array(
                            'format'  => 'Y-m-d',
                            'message' => 'Das Datum entspricht nicht dem '
                                . 'Format "%format%"!',
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'time',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'Date',
                        'options' => array(
                            'format'  => 'H:i:s',
                            'message' => 'Die Zeit entspricht nicht dem '
                                . 'Format "%format%"!',
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'status',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $this->getStatusHaystack(),
                            'message'  => 'Ungültiger Status!',
                        ),
                    ),
                ),
            )
        );
    }
}