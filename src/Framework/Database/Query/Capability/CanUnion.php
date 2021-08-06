<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\Capability;

use Src\Framework\Database\Query\UnionQuery;
use Src\Framework\Database\StatementInterface;

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