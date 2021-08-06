<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\Capability;

use Src\Framework\Database\ExpressionInterface;
use Src\Framework\Database\StatementInterface;
use function Src\Framework\Database\identify;

trait HasReturning
{
    /** @var StatementInterface */
    protected $returning;

    public function returning($column): self
    {
        $this->returning = identify($column);
        return $this;
    }

    protected function applyReturning(ExpressionInterface $query): ExpressionInterface
    {
        return $this->returning ? $query->append('RETURNING %s', $this->returning) : $query;
    }
}