<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\SqlServer;

use Src\Framework\Database\ExpressionInterface;
use Src\Framework\Database\Query;
use function Src\Framework\Database\literal;

class DeleteQuery extends Query\DeleteQuery
{
    protected function startExpression(): ExpressionInterface
    {
        $query = parent::startExpression();
        if (is_int($this->limit)) {
            $query = $query->append('TOP(%d)', literal($this->limit));
        }
        return $query;
    }

    protected function applyLimit(ExpressionInterface $query): ExpressionInterface
    {
        return $query;
    }
}