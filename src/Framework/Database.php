<?php

/**
 * ===========================
 * Database Driver
 * ===========================
 */

namespace Framework;

class Database
{
    // Database connection
    public function __construct(protected $database = '')
    {
        $this->database = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }
    
    // Query handler
    public function query($query)
    {
        return $this->database->query($query);
    }
}