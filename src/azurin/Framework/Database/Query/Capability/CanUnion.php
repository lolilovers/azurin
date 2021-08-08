<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query\Capability;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\Query\UnionQuery;

trait CanUnion
{
    public function union(StatementInterface $right): UnionQuery
    {
        return new UnionQuery($this->engine, $this, $right);
    }

    public function unionAll(StatementInterface $right): UnionQuery
    {
        return $this->union($right)->all();
    }
}