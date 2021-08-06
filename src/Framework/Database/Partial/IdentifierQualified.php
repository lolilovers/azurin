<?php
declare(strict_types=1);

namespace Src\Framework\Database\Partial;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\StatementInterface;
use function Src\Framework\Database\alias;

final class IdentifierQualified implements StatementInterface
{
    /** @var StatementInterface[] */
    private $identifiers;

    public function __construct(
        StatementInterface ...$identifiers
    ) {
        $this->identifiers = $identifiers;
    }

    public function sql(EngineInterface $engine): string
    {
        return $engine->flattenSql('.', ...$this->identifiers);
    }

    public function params(EngineInterface $engine): array
    {
        return $engine->flattenParams(...$this->identifiers);
    }
}