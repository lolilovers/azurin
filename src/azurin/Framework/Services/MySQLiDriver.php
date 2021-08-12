<?php

namespace Azurin\Framework\Services;

class MySQLiDriver
{
    protected $mysqli;
    protected $prepared;
    protected $statement;

    // Database configuration
    public function __construct(
        protected string $hostname,
        protected string $username,
        protected string $password,
        protected string $database,
        protected int $port
    ){
        // Create connection
        $this->mysqli = new \mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );
    }

    // Query service
    public function query($query, $value = null)
    {
        // Sanitize query
        $query  = $this->mysqli->real_escape_string($query);

        if (empty($value)) {
            // Non prepared query
            $this->prepared     = false;
            $this->statement    = $this->mysqli->query($query);

            return $this->statement;
        } else {
            // Prepared query
            $this->prepared = true;
            $this->prepare($query);
            $this->bindParam($value);

            return $this->execute();
        }
    }

    // Prepare query
    public function prepare($query)
    {
        $this->statement = $this->mysqli->prepare($query);

        return $this->statement;
    }

    // Bind params
    public function bindParam($value)
    {
        $bind = '';
        
        foreach ($value as $v) {
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
        return $this->mysqli->close();
    }

    // Get all result
    public function result()
    {
        if($this->prepared) {
            $result = $this->statement->get_result()->fetch_all();
        } else {
            $result = $this->statement->fetch_all();
        }

        return $result;
    }

    // Get associative array
    public function resultAssoc()
    {
        if($this->prepared) {
            $result = $this->statement->get_result()->fetch_assoc();
        } else {
            $result = $this->statement->fetch_assoc();
        }

        return $result;
    }

    // Get result array
    public function resultArray()
    {
        if($this->prepared) {
            $result = $this->statement->get_result()->fetch_array();
        } else {
            $result = $this->statement->fetch_array();
        }

        return $result;
    }

    // Get result row
    public function resultRow()
    {
        if($this->prepared) {
            $result = $this->statement->get_result()->fetch_row();
        } else {
            $result = $this->statement->fetch_row();
        }

        return $result;
    }

    // Bind param validator
    public function bind($value)
    {
        if (is_string($value)) {
            $bind = 's';
        } elseif (is_double($value)) {
            $bind = 'd';
        } elseif (is_integer($value)) {
            $bind = 'i';
        } elseif (is_bool($value)) {
            $bind = 'b';
        }

        return $bind;
    }
}