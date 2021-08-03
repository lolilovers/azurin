<?php

/**
 * ===========================
 * Base Model
 * ===========================
 */

namespace Framework;

use Framework\Database;

class Model 
{
    // Query service
    public function query($query)
    {
        $db = new Database;
        return $db->query($query);
    }
}
