<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query\Capability;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\StatementInterface;

use function Azurin\Framework\Database\identify;

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