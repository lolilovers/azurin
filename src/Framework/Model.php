<?php

/**
 * ===========================
 * Base Model
 * ===========================
 */

namespace App\Framework;

use App\Framework\Database;

class Model 
{
    public function query($query)
    {
        $db = new Database;
        return $db->query($query);
    }
}
