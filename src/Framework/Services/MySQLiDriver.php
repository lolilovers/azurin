<?php

/**
 * ===========================
 * MySQLi Driver
 * ===========================
 */

namespace Src\Framework\Services;

class MySQLiDriver
{
    protected $database;
    protected $statement;

    // Database configuration
    public function __construct(
        protected $hostname,
        protected $username,
        protected $password,
        protected $dbselect
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
        // Sanitize query
        $query  = $this->database->real_escape_string($query);

        // Non prepared query
        if ($value == null) {
            return $this->database->query($query);
        }
        // Prepared query
        else {
            $this->prepare($query);
            $this->bindParam($value);

            return $this->execute();
        }
    }

    // Prepare query
    public function prepare($query)
    {
        $this->statement = $this->database->prepare($query);

        return $this->statement;
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

    // Close connection
    public function close()
    {
        return $this->database->close();
    }

    // Get all result
    public function result()
    {
        return $this->statement->get_result()->fetch_all();
    }

    // Get associative array
    public function resultAssoc()
    {
        return $this->statement->get_result()->fetch_assoc();
    }

    // Get result array
    public function resultArray()
    {
        return $this->statement->get_result()->fetch_array();
    }

    // Get result row
    public function resultRow()
    {
        return $this->statement->get_result()->fetch_row();
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
}