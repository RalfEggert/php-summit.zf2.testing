<?php
return array(
    'router'          => array(
        'routes' => array(
            'event-admin' => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/event/admin',
                    'defaults' => array(
                        'controller' => 'event-admin',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'action' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/:action[/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]*',
                            ),
                            'defaults'    => array(),
                        ),
                    ),
                ),
            ),
            'event-order' => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/event/order',
                    'defaults' => array(
                        'controller' => 'event-order',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'action' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/:action[/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]*',
                            ),
                            'defaults'    => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'controllers'     => array(
        'factories' => array(
            'event-admin' => 'Event\Controller\AdminControllerFactory',
            'event-order' => 'Event\Controller\OrderControllerFactory',
        ),
    ),

    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'Event\Entity\Event' => 'Event\Entity\EventEntity',
            'Event\Entity\Order' => 'Event\Entity\OrderEntity',
        ),
        'factories'  => array(
            'Event\Table\Event'   => 'Event\Table\EventTableFactory',
            'Event\Service\Event' => 'Event\Service\EventServiceFactory',
            'Event\Config'        => 'Event\Config\EventConfigFactory',
            'Event\Table\Order'   => 'Event\Table\OrderTableFactory',
            'Event\Service\Order' => 'Event\Service\OrderServiceFactory',
        ),
        'shared'     => array(
            'Event\Entity\Event' => false,
            'Event\Entity\Order' => false,
        ),
    ),

    'input_filters'   => array(
        'factories' => array(
            'Event\Filter' => 'Event\InputFilter\EventFilterFactory',
            'Order\Filter' => 'Event\InputFilter\OrderFilterFactory',
        ),
    ),

    'form_elements'   => array(
        'invokables' => array(
            'Order\Form'           => 'Event\Form\OrderForm',
            'OrderRowSeatFieldset' => 'Event\Form\OrderRowSeatFieldset',
            'OrderRowFieldset'     => 'Event\Form\OrderRowFieldset',
        ),
        'factories'  => array(
            'Event\Form' => 'Event\Form\EventFormFactory',
        ),
    ),

    'hydrators'       => array(
        'invokables' => array(
            'Event\Hydrator' => 'Event\Hydrator\EventHydrator',
            'Order\Hydrator' => 'Event\Hydrator\OrderHydrator',
        ),
    ),

    'view_helpers'    => array(
        'factories' => array(
            'EventStatus' => 'Event\View\Helper\EventStatusFactory',
        ),
    ),

    'navigation'      => array(
        'default' => array(
            array(
                'label' => 'Events verwalten',
                'route' => 'event-admin',
                'pages' => array(
                    array(
                        'label'   => 'Event anzeigen',
                        'route'   => 'event-admin/action',
                        'action'  => 'show',
                        'visible' => false,
                    ),
                    array(
                        'label'   => 'Event anlegen',
                        'route'   => 'event-admin/action',
                        'action'  => 'create',
                        'visible' => false,
                    ),
                    array(
                        'label'   => 'Event bearbeiten',
                        'route'   => 'event-admin/action',
                        'action'  => 'update',
                        'visible' => false,
                    ),
                ),
            ),
            array(
                'label' => 'Veranstaltung buchen',
                'route' => 'event-order',
                'pages' => array(
                    array(
                        'label'   => 'Platz buchen',
                        'route'   => 'event-order/action',
                        'action'  => 'book',
                        'visible' => false,
                    ),
                ),
            ),
        ),
    ),
);