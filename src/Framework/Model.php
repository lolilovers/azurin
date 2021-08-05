<?php

/**
 * ===========================
 * Base Model
 * ===========================
 */

namespace Src\Framework;

use Src\Framework\Database;

class Model 
{
    protected $table;
    protected $primaryKey;

    // Non prepared query
    public function query($query)
    {
        $db = new Database;
        return $db->query($query);
    }

    // Prepared query
    public function preparedQuery($query, $bind, $value)
    {
        $db = new Database;
        return $db->preparedQuery($query, $bind, $value);
    }

    // SELECT
    public function select($value = null)
    {
        // Find all
        if(! $value) {
            $stmt = "SELECT * FROM $this->table";
        }
        // Find where value of primary key
        else {
            $stmt = "SELECT * FROM $this->table WHERE $this->primaryKey = $value";
        }
        return $this->query($stmt);
    }

    // INSERT
    public function insert($columns, $values)
    {
        $stmt = "INSERT INTO $this->table ($columns) VALUES ($values)";
        return $this->query($stmt);
    }

    // UPDATE
    public function update($col, $val, $id)
    {
        $stmt = "UPDATE $this->table SET $col=$val WHERE $this->primaryKey=$id";
        return $this->query($stmt);
    }

    // DELETE
    public function delete($value)
    {
        $stmt = "DELETE FROM $this->table WHERE $this->primaryKey = $value";
        return $this->query($stmt);
    }

    // COUNT
    public function count($key)
    {
        $stmt = "SELECT COUNT($key) AS $key FROM $this->table";
        return $this->query($stmt);
    }

    // SUM
    public function sum($key)
    {
        $stmt = "SELECT SUM($key) AS $key FROM $this->table";
        return $this->query($stmt);
    }

    // AVG
    public function avg($key)
    {
        $stmt = "SELECT AVG($key) AS $key FROM $this->table";
        return $this->query($stmt);
    }
}
