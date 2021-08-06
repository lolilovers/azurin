<?php
declare(strict_types=1);

namespace Src\Framework\Database\Partial;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\StatementInterface;

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