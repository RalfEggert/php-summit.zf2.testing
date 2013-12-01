<?php
namespace Event\View\Helper;

use Zend\View\Helper\AbstractHelper;

class EventStatus extends AbstractHelper
{
    /**
     * @var array
     */
    protected $statusOptions;

    /**
     * @param $statusId
     */
    function __invoke($statusId)
    {
        $statusOptions = $this->getStatusOptions();

        if (isset($statusOptions[$statusId])) {
            return $statusOptions[$statusId];
        }

        return '<em>unbekannter Status</em>';
    }

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

} 