<?php

/**
 * ===========================
 * Database Driver
 * ===========================
 */

namespace App\Framework;

class Database
{
    // construct this class
    public function __construct(protected $database = '')
    {
        $this->database = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }
    // query
    public function query($query)
    {
        return $this->database->query($query);
    }
}