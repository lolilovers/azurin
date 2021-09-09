<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query\Capability;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\StatementInterface;

use function Azurin\Framework\Database\identifyAll;
use function Azurin\Framework\Database\listing;

trait HasFrom
{
    /** @var StatementInterface[] */
    protected $from = [];

    public function from(...$tables): self
    {
        $this->from = identifyAll($tables);
        return $this;
    }

    public function addFrom(...$tables): self
    {
        return $this->from(...array_merge($this->from, $tables));
    }

    protected function applyFrom(ExpressionInterface $query): ExpressionInterface
    {
        return $this->from ? $query->append('FROM %s', listing($this->from)) : $query;
    }
}