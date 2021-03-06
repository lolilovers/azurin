<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Query;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\StatementInterface;

use function Azurin\Framework\Database\identify;
use function Azurin\Framework\Database\express;
use function Azurin\Framework\Database\listing;
use function Azurin\Framework\Database\param;

class UpdateQuery extends AbstractQuery
{
    use Capability\HasWhere;

    /** @var StatementInterface */
    protected $table;

    /** @var StatementInterface */
    protected $set;

    public function table($table): self
    {
        $this->table = identify($table);
        return $this;
    }

    public function set(array $map): self
    {
        $this->set = listing(array_map(
            function ($key, $value): StatementInterface {
                return express('%s = %s', identify($key), param($value));
            },
            array_keys($map),
            $map
        ));
        return $this;
    }

    public function asExpression(): ExpressionInterface
    {
        $query = $this->startExpression();
        $query = $this->applyTable($query);
        $query = $this->applySet($query);
        $query = $this->applyWhere($query);

        return $query;
    }

    protected function startExpression(): ExpressionInterface
    {
        return express('UPDATE');
    }

    protected function applyTable(ExpressionInterface $query): ExpressionInterface
    {
        return $this->table ? $query->append('%s', $this->table) : $query;
    }

    protected function applySet(ExpressionInterface $query): ExpressionInterface
    {
        return $this->set ? $query->append('SET %s', $this->set): $query;
    }
}