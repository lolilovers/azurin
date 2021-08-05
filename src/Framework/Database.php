<?php

/**
 * ===========================
 * Database Driver
 * ===========================
 */

namespace Src\Framework;

class Database
{
    // Database connection
    public function __construct(
        protected $database = ''
    ){
        $this->database = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }
    
    // Non prepared query
    public function query($query)
    {
        return $this->database->query($query);
    }

    // Prepared query
    public function preparedQuery($query, $bind, $value)
    {
        $stmt = $this->database->prepare($query);
        $stmt->bind_param($bind, $value);
        return $stmt->execute();
    }
}