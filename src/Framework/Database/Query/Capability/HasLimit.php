<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query\Capability;

use Src\Framework\Database\ExpressionInterface;
use function Src\Framework\Database\literal;

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