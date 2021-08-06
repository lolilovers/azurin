<?php

/**
 * ===========================
 * Session
 * ===========================
 */

namespace Src\Framework;

class Session
{
    // Start session
    public function __construct()
    {
        if(! isset($_SESSION) && session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Get
    public function get($id)
    {
        if(! empty($_SESSION[$id])) {
            $data = $_SESSION[$id];    
        }
        return $data;
    }

    // Set
    public function set($id, $data)
    {
        return $_SESSION[$id] = $data;
    }

    // destroy
    public function destroy()
    {
        return session_destroy();
    }
}