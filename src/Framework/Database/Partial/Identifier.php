<?php
declare(strict_types=1);

namespace Src\Framework\Database\Partial;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\StatementInterface;

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