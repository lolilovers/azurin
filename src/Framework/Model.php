<?php

/**
 * ===========================
 * Base Model
 * ===========================
 */

namespace Src\Framework;

use Src\Framework\Services\MySQLiDriver;
use Src\Framework\Database\Engine\MySqlEngine;
use Src\Framework\Database\QueryFactory;
use function Src\Framework\Database\field;

class Model 
{
    protected $table;
    protected $primaryKey;

    // Create mysqli connection
    public function mysqli()
    {
        $mysqli = new MySQLiDriver(
            DB_SERVER,
            DB_USERNAME,
            DB_PASSWORD,
            DB_NAME,
            $this->table,
            $this->primaryKey
        );

        return $mysqli;
    }

    // Create query builder
    public function builder()
    {
        $factory = new QueryFactory(new MySqlEngine());
        
        return $factory;
    }
}