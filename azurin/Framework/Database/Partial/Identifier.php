<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\EngineInterface;

final class Identifier implements StatementInterface
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function sql(EngineInterface $engine): string
    {
        return $engine->escapeIdentifier($this->name);
    }

    public function params(EngineInterface $engine): array
    {
        return [];
    }
}