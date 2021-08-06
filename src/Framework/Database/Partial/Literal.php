<?php
declare(strict_types=1);

namespace Src\Framework\Database\Partial;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\StatementInterface;

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
