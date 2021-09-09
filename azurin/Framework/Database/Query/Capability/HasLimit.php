<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query\Capability;

use Azurin\Framework\Database\ExpressionInterface;

use function Azurin\Framework\Database\literal;

trait HasLimit
{
    /** @var int|null */
    protected $limit;

    public function limit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    protected function applyLimit(ExpressionInterface $query): ExpressionInterface
    {
        return is_int($this->limit) ? $query->append('LIMIT %d', literal($this->limit)): $query;
    }
}