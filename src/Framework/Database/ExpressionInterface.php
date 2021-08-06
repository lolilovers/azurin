<?php
declare(strict_types=1);

namespace Src\Framework\Database;

interface ExpressionInterface extends StatementInterface
{
    /**
     * Create a new expression with additional replacements
     */
    public function append(string $pattern, StatementInterface ...$replacements): ExpressionInterface;
}