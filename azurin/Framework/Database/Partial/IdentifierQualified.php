<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\EngineInterface;

use function Azurin\Framework\Database\alias;

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