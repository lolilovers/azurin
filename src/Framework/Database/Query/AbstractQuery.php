<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\ExpressionInterface;
use Src\Framework\Database\QueryInterface;
use Src\Framework\Database\Query;

abstract class AbstractQuery implements QueryInterface
{
    /** @var EngineInterface */
    protected $engine;

    public function __construct(
        EngineInterface $engine
    ) {
        $this->engine = $engine;
    }

    abstract public function asExpression(): ExpressionInterface;

    abstract protected function startExpression(): ExpressionInterface;

    public function compile(): Query
    {
        $query = $this->asExpression();
        return new Query(
            $query->sql($this->engine),
            $query->params($this->engine)
        );
    }

    public function sql(EngineInterface $engine): string
    {
        return $this->asExpression()->sql($engine);
    }

    public function params(EngineInterface $engine): array
    {
        return $this->asExpression()->params($engine);
    }
}