<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\Capability;

use Src\Framework\Database\ExpressionInterface;
use Src\Framework\Database\StatementInterface;

use function Src\Framework\Database\listing;
use function Src\Framework\Database\order;

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
