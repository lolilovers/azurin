<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\EngineInterface;

final class Listing implements StatementInterface
{
    /** @var string */
    private $separator;

    /** @var StatementInterface[] */
    private $statements;

    public function __construct(
        string $separator,
        StatementInterface ...$statements
    ) {
        $this->separator = $separator;
        $this->statements = $statements;
    }

    public function sql(EngineInterface $engine): string
    {
        return $engine->flattenSql($this->separator, ...$this->statements);
    }

    public function params(EngineInterface $engine): array
    {
        return $engine->flattenParams(...$this->statements);
    }
}