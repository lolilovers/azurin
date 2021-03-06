<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Builder;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\CriteriaInterface;
use Azurin\Framework\Database\Partial\{
    LikeBegins,
    LikeContains,
    LikeEnds
};

use function Azurin\Framework\Database\criteria;

class LikeBuilder
{
    /** @var StatementInterface */
    private $statement;

    public function __construct(StatementInterface $statement)
    {
        $this->statement = $statement;
    }

    public function begins(string $value): CriteriaInterface
    {
        return $this->like(new LikeBegins($value));
    }

    public function notBegins(string $value): CriteriaInterface
    {
        return $this->notLike(new LikeBegins($value));
    }

    public function contains(string $value): CriteriaInterface
    {
        return $this->like(new LikeContains($value));
    }

    public function notContains(string $value): CriteriaInterface
    {
        return $this->notLike(new LikeContains($value));
    }

    public function ends(string $value): CriteriaInterface
    {
        return $this->like(new LikeEnds($value));
    }

    public function notEnds(string $value): CriteriaInterface
    {
        return $this->notLike(new LikeEnds($value));
    }

    protected function like(StatementInterface $value): CriteriaInterface
    {
        return criteria('%s LIKE %s', $this->statement, $value);
    }

    protected function notLike(StatementInterface $value): CriteriaInterface
    {
        return criteria('%s NOT LIKE %s', $this->statement, $value);
    }
}