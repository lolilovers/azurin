<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query\Capability;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\StatementInterface;

use function Azurin\Framework\Database\listing;
use function Azurin\Framework\Database\order;

trait HasOrderBy
{
    /** @var StatementInterface[] */
    protected $orderBy;

    public function orderBy($column, string $direction = ''): self
    {
        if (empty($column)) {
            $this->orderBy = [];
            return $this;
        }
        
        $this->orderBy[] = order($column, $direction);
        return $this;
    }

    protected function applyOrderBy(ExpressionInterface $query): ExpressionInterface
    {
        return $this->orderBy ? $query->append('ORDER BY %s', listing($this->orderBy)) : $query;
    }
}