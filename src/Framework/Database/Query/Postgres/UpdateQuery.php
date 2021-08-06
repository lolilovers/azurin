<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\Postgres;

use Src\Framework\Database\ExpressionInterface;
use Src\Framework\Database\Query;

class UpdateQuery extends Query\UpdateQuery
{
    use Query\Capability\HasReturning;

    public function asExpression(): ExpressionInterface
    {
        $query = parent::asExpression();
        $query = $this->applyReturning($query);

        return $query;
    }
}