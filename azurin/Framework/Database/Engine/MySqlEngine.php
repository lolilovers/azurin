<?php
declare(strict_types=1);

namespace Azurin\Framework\Database\Engine;

use Azurin\Framework\Database\Query;

class MySqlEngine extends BasicEngine
{
    public function makeSelect(): Query\SelectQuery
    {
        return new Query\MySql\SelectQuery($this);
    }

    public function makeInsert(): Query\InsertQuery
    {
        return new Query\MySql\InsertQuery($this);
    }

    public function escapeIdentifier(string $identifier): string
    {
        return "`$identifier`";
    }
}