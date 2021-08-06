<?php
declare(strict_types=1);

namespace Src\Framework\Database;

interface StatementInterface
{
    public function sql(EngineInterface $engine): string;

    public function params(EngineInterface $engine): array;
}
