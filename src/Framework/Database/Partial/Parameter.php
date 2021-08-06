<?php
declare(strict_types=1);

namespace Src\Framework\Database\Partial;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\StatementInterface;

final class Parameter implements StatementInterface
{
    /** @var string */
    private $sql = '?';

    /** @var array */
    private $params = [];

    public function __construct($value)
    {
        if (is_bool($value) || is_null($value)) {
            $this->sql = $value;
        } else {
            $this->params[] = $value;
        }
    }

    public function sql(EngineInterface $engine): string
    {
        return $engine->exportParameter($this->sql);
    }

    public function params(EngineInterface $engine): array
    {
        return $this->params;
    }
}
