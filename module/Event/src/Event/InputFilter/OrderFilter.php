<?php
namespace Event\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Class OrderFilter
 *
 * @package Event\InputFilter
 */
class OrderFilter extends InputFilter
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
                'name'       => 'email',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                        'options' => array(
                            'useDomainCheck' => false,
                            'message'        =>
                                'Die E-Mail Adresse scheint ungültig '
                                . 'zu sein!',
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'iban',
                'required'   => true,
                'validators' => array(
                    array(
                        'name' => 'Iban',
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'bic',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'Regex',
                        'options' => array(
                            'pattern' => '/^[A-Z]{6}[a-zA-Z1-9]{2,5}$/',
                            'message' => 'BIC-Code ungültig',
                        ),
                    ),
                ),
            )
        );
    }
}