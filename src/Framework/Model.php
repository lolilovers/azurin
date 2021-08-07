<?php

/**
 * ===========================
 * Base Model
 * ===========================
 */

namespace Src\Framework;

use Src\Framework\Services\MySQLiDriver;
use Src\Framework\Database\QueryFactory;
use Src\Framework\Database\Engine\MySqlEngine;
use Src\Framework\Database\Engine\BasicEngine;
use Src\Framework\Database\Engine\CommonEngine;
use Src\Framework\Database\Engine\PostgresEngine;
use Src\Framework\Database\Engine\SqliteEngine;
use Src\Framework\Database\Engine\SqlServerEngine;
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
            DB_NAME
        );

        return $mysqli;
    }

    // Create query builder
    public function builder($engine = 'mysql')
    {
        if($engine == 'mysql') {
            $factory = new QueryFactory(new MySqlEngine());
        }
        else if($engine == 'basic') {
            $factory = new QueryFactory(new BasicEngine());
        }
        else if($engine == 'common') {
            $factory = new QueryFactory(new CommonEngine());
        }
        else if($engine == 'postgresql') {
            $factory = new QueryFactory(new PostgresEngine());
        }
        else if($engine == 'sqlserver') {
            $factory = new QueryFactory(new SqlServerEngine());
        }
        else if($engine == 'sqlite') {
            $factory = new QueryFactory(new SqliteEngine());
        }
        else {
            $factory = null;
        }

        return $factory;
    }

    // SELECT
    public function select($value = null)
    {
        // Find all
        if($value == null) {
            $stmt   = "SELECT * FROM $this->table";
            
            return $this->mysqli()->query($stmt)->fetch_all();
        }
        // Find where matching value of key
        else {
            $stmt   = "SELECT * FROM $this->table WHERE $this->primaryKey = ?";
            $select = $this->mysqli();
            $select->query($stmt, [ $value ]);
            
            return $select->result();
        }
    }

    // INSERT
    public function insert($column, $value)
    {
        $field  = ' ? ';
        $count  = count($value);
        for ($i=1;$i<$count;$i++)
        {
            $field = $field . ', ? ';
        }
        $query  = "INSERT INTO $this->table ( $column ) VALUES ( $field )";

        return $this->mysqli()->query($query, $value);
    }

    // UPDATE
    public function update($column, $value, $keyValue)
    {
        $query  = "UPDATE $this->table SET $column = ? WHERE $this->primaryKey = ?";

        return $this->mysqli()->query($query, [ $value, $keyValue ]);
    }

    // DELETE
    public function delete($value)
    {
        $query  = "DELETE FROM $this->table WHERE $this->primaryKey = ?";
        
        return $this->mysqli()->query($query, [ $value ]);
    }

    // COUNT
    public function count($key)
    {
        $query  = "SELECT COUNT( ? ) AS $key FROM $this->table";
        $count  = $this->mysqli();
        $count->query($query, [ $key ]);

        return $count->resultAssoc();
    }

    // SUM
    public function sum($key)
    {
        $query = "SELECT SUM( ? ) AS $key FROM $this->table";
        $sum   = $this->mysqli();
        $sum->query($query, [ $key ]);

        return $sum->resultAssoc();
    }

    // AVG
    public function avg($key)
    {
        $query = "SELECT AVG( ? ) AS $key FROM $this->table";
        $avg   = $this->mysqli();
        $avg->query($query, [ $key ]);
        
        return $avg->resultAssoc();
    }

    // MIN
    public function min($key)
    {
        $query = "SELECT MIN( ? ) AS $key FROM $this->table";
        $min   = $this->mysqli();
        $min->query($query, [ $key ]);
        
        return $min->resultAssoc();
    }

    // MAX
    public function max($key)
    {
        $query = "SELECT MAX( ? ) AS $key FROM $this->table";
        $max   = $this->mysqli();
        $max->query($query, [ $key ]);
        
        return $max->resultAssoc();
    }
}