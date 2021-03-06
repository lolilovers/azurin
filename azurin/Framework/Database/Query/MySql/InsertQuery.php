<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query\MySql;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\Query;

class InsertQuery extends Query\InsertQuery
{
    /** @var bool */
    protected $ignore = false;

    public function ignore(bool $status): self
    {
        $this->ignore = $status;
        return $this;
    }

    protected function startExpression(): ExpressionInterface
    {
        $query = parent::startExpression();
        if ($this->ignore) {
            $query = $query->append('IGNORE');
        }
        return $query;
    }
}