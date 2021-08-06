<?php
declare(strict_types=1);

namespace Src\Framework\Database\Builder;

use Src\Framework\Database\CriteriaInterface;
use Src\Framework\Database\StatementInterface;
use function Src\Framework\Database\criteria;
use function Src\Framework\Database\listing;

class CriteriaBuilder
{
    /** @var StatementInterface */
    private $statement;

    public function __construct(StatementInterface $statement)
    {
        $this->statement = $statement;
    }

    public function between($start, $end): CriteriaInterface
    {
        return criteria('%s BETWEEN %s AND %s', $this->statement, $start, $end);
    }

    public function notBetween($start, $end): CriteriaInterface
    {
        return criteria('%s NOT BETWEEN %s AND %s', $this->statement, $start, $end);
    }

    public function in(...$values): CriteriaInterface
    {
        return criteria("%s IN (%s)", $this->statement, listing($values));
    }

    public function notIn(...$values): CriteriaInterface
    {
        return criteria("%s NOT IN (%s)", $this->statement, listing($values));
    }

    public function eq($value): CriteriaInterface
    {
        return criteria('%s = %s', $this->statement, $value);
    }

    public function notEq($value): CriteriaInterface
    {
        return criteria('%s != %s', $this->statement, $value);
    }

    public function gt($value): CriteriaInterface
    {
        return criteria('%s > %s', $this->statement, $value);
    }

    public function gte($value): CriteriaInterface
    {
        return criteria('%s >= %s', $this->statement, $value);
    }

    public function lt($value): CriteriaInterface
    {
        return criteria('%s < %s', $this->statement, $value);
    }

    public function lte($value): CriteriaInterface
    {
        return criteria('%s <= %s', $this->statement, $value);
    }

    public function isNull(): CriteriaInterface
    {
        return criteria('%s IS NULL', $this->statement);
    }

    public function isNotNull(): CriteriaInterface
    {
        return criteria('%s IS NOT NULL', $this->statement);
    }
}