<?php

namespace Kint\Object;

class ResourceObject extends BasicObject
{
    public $resource_type;

    public function getType()
    {
        if ($this->resource_type) {
            return $this->resource_type.' resource';
        }

        return 'resource';
    }

    public function transplant(BasicObject $old)
    {
        parent::transplant($old);

        if ($old instanceof self) {
            $this->resource_type = $old->resource_type;
        }
    }
}
