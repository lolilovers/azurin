<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\ExpressionInterface;
use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\EngineInterface;

final class Expression implements ExpressionInterface
{
    /** @var string */
    private $pattern;

    /** @var StatementInterface[] */
    private $replacements;

    public function __construct(
        string $pattern,
        StatementInterface ...$replacements
    ) {
        $this->pattern = $pattern;
        $this->replacements = $replacements;
    }

    public function append(string $pattern, StatementInterface ...$replacements): ExpressionInterface
    {
        return new self("{$this->pattern} $pattern", ...array_merge($this->replacements, $replacements));
    }

    public function sql(EngineInterface $engine): string
    {
        return vsprintf($this->pattern, array_map($engine->extractSql(), $this->replacements));
    }

    public function params(EngineInterface $engine): array
    {
        return $engine->flattenParams(...$this->replacements);
    }
}