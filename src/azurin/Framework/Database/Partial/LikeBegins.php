<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Partial;

use Azurin\Framework\Database\StatementInterface;
use Azurin\Framework\Database\EngineInterface;

final class LikeBegins implements StatementInterface
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
        return ["$value%"];
    }
}