<?php

/**
 * ===========================
 * MySQLi Driver
 * ===========================
 */

namespace Src\Framework;

class MySQLiDriver
{
    protected $database;
    protected $statement;

    // Database configuration
    public function __construct(
        protected $hostname,
        protected $username,
        protected $password,
        protected $dbselect,
        protected $table,
        protected $primaryKey
    ){
        // Create connection
        $this->database = new \mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->dbselect
        );
    }

    // Query service
    public function query($query, $value = null)
    {
        // Non prepared query
        if ($value == null) {

            return $this->database->query($query);
        }
        // Prepared query
        else {
            $this->prepare($query);
            $this->bindParam($value);

            return $this->statement;
        }
    }

    // Prepare query
    public function prepare($query)
    {
        return $this->statement = $this->database->prepare($query);
    }

    // Bind params
    public function bindParam($value)
    {
        $bind = '';
        
        foreach ($value as $v)
        {
            $bind = $bind . $this->bind($v);
        }

        return $this->statement->bind_param($bind, ...$value);
    }

    // Execute prepared query
    public function execute()
    {
        return $this->statement->execute();
    }

    // Get all result
    public function result()
    {
        $this->execute();

        return $this->statement->get_result()->fetch_all();
    }

    // Get associative array
    public function resultAssoc()
    {
        $this->execute();

        return $this->statement->get_result()->fetch_assoc();
    }

    // Get result array
    public function resultArray()
    {
        $this->execute();

        return $this->statement->get_result()->fetch_array();
    }

    // Bind param validator
    public function bind($value)
    {
        if (is_string($value)) {
            $bind = 's';
        }
        else if (is_double($value)) {
            $bind = 'd';
        }
        else if (is_integer($value)) {
            $bind = 'i';
        }
        else if (is_bool($value)) {
            $bind = 'b';
        }

        return $bind;
    }

    // SELECT
    public function select($value = null)
    {
        // Find all
        if(! $value) {
            $stmt = "SELECT * FROM $this->table";

            return $this->query($stmt)->fetch_all();
        }
        // Find where matching value of primary key
        else {
            $stmt  = "SELECT * FROM $this->table WHERE $this->primaryKey = ?";
            $this->query($stmt, [ $value ]);

            return $this->resultAssoc();
        }
    }

    // INSERT
    public function insert($column, $value)
    {
        $field = ' ? ';
        $count = count($value);
        for ($i=1;$i<$count;$i++)
        {
            $field = $field . ', ? ';
        }
        $query  = "INSERT INTO $this->table ( $column ) VALUES ( $field )";
        $this->query($query, $value);

        return $this->execute();
    }

    // UPDATE
    public function update($column, $value, $key)
    {
        $query = "UPDATE $this->table SET $column = ? WHERE $this->primaryKey = ?";
        $this->query($query, [ $value, $key ]);

        return $this->execute();
    }

    // DELETE
    public function delete($value)
    {
        $query = "DELETE FROM $this->table WHERE $this->primaryKey = ?";
        $this->query($query, [ $value ]);

        return $this->execute();
    }

    // COUNT
    public function count($key)
    {
        $query = "SELECT COUNT( ? ) AS $key FROM $this->table";
        $this->query($query, [ $key ]);

        return $this->resultAssoc();
    }

    // SUM
    public function sum($key)
    {
        $query = "SELECT SUM( ? ) AS $key FROM $this->table";
        $this->query($query, [ $key ]);

        return $this->resultAssoc();
    }

    // AVG
    public function avg($key)
    {
        $query = "SELECT AVG( ? ) AS $key FROM $this->table";
        $this->query($query, [ $key ]);
        
        return $this->resultAssoc();
    }
}