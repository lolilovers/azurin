<?php

namespace Kint\Object;

use DateTime;

class DateTimeObject extends InstanceObject
{
    public $dt;

    public $hints = array('object', 'datetime');

    public function __construct(DateTime $dt)
    {
        parent::__construct();

        $this->dt = clone $dt;
    }

    public function getValueShort()
    {
        $stamp = $this->dt->format('Y-m-d H:i:s');
        if ((int) ($micro = $this->dt->format('u'))) {
            $stamp .= '.'.$micro;
        }
        $stamp .= $this->dt->format('P T');

        return $stamp;
    }
}
