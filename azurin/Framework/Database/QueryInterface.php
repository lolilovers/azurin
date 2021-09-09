<?php

declare(strict_types=1);

namespace Azurin\Framework\Database;

interface QueryInterface extends StatementInterface
{
    public function asExpression(): ExpressionInterface;

    public function compile(): Query;
}