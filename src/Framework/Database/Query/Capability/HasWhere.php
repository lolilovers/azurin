<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\Capability;

use Src\Framework\Database\CriteriaInterface;
use Src\Framework\Database\ExpressionInterface;

trait HasWhere
{
    /** @var CriteriaInterface */
    protected $where;

    public function where(CriteriaInterface $criteria): self
    {
        $this->where = $criteria;
        return $this;
    }

    public function andWhere(CriteriaInterface $criteria): self
    {
        if ($this->where === null) {
            return $this->where($criteria);
        }

        $this->where = $this->where->and($criteria);
        return $this;
    }

    public function orWhere(CriteriaInterface $criteria): self
    {
        if ($this->where === null) {
            return $this->where($criteria);
        }

        $this->where = $this->where->or($criteria);
        return $this;
    }

    protected function applyWhere(ExpressionInterface $query): ExpressionInterface
    {
        return $this->where ? $query->append('WHERE %s', $this->where) : $query;
    }
}