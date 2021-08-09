<?php

/**
 * ===========================
 * Session
 * ===========================
 */

namespace Azurin\Framework\Services;

class Session
{
    // Start session
    public function __construct()
    {
        if (! isset($_SESSION) && session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Get
    public function get($id)
    {
        if (! empty($_SESSION[$id])) {
            $data = $_SESSION[$id];
        } else {
            $data = null;
        }
        
        return $data;
    }

    // Set
    public function set($id, $data)
    {
        $_SESSION[$id] = $data;
    }

    // Get and forget
    public function getForget($id)
    {
        if (! empty($_SESSION[$id])) {
            $data           = $_SESSION[$id];
            $_SESSION[$id]  = null;
        } else {
            $data = null;
        }

        return $data;
    }

    // destroy
    public function destroy()
    {
        return session_destroy();
    }
}