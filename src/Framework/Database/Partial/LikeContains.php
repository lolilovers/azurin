<?php
declare(strict_types=1);

namespace Src\Framework\Database\Partial;

use Src\Framework\Database\EngineInterface;
use Src\Framework\Database\StatementInterface;

final class LikeContains implements StatementInterface
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function sql(EngineInterface $engine): string
    {
        return '?';
    }

    public function params(EngineInterface $engine): array
    {
        $value = $engine->escapeLike($this->value);
        return ["%$value%"];
    }
}