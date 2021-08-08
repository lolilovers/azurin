<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\CriteriaInterface;
use Azurin\Framework\Database\EngineInterface;

use function Azurin\Framework\Database\express;

final class Criteria implements CriteriaInterface
{
    /** @var ExpressionInterface */
    private $expression;

    public function __construct(
        ExpressionInterface $expression
    ) {
        $this->expression = $expression;
    }

    public function and(CriteriaInterface $right): CriteriaInterface
    {
        return new self($this->expression->append('AND %s', $right));
    }

    public function or(CriteriaInterface $right): CriteriaInterface
    {
        return new self($this->expression->append('OR %s', $right));
    }

    public function sql(EngineInterface $engine): string
    {
        return $this->expression->sql($engine);
    }

    public function params(EngineInterface $engine): array
    {
        return $this->expression->params($engine);
    }
}