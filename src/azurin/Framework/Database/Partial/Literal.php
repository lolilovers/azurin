<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\EngineInterface;

final class Literal implements StatementInterface
{
    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function sql(EngineInterface $engine): string
    {
        return (string) $this->value;
    }

    public function params(EngineInterface $engine): array
    {
        return [];
    }
}