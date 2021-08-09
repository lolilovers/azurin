<?php

/**
 * ===========================
 * Cookie
 * ===========================
 */

namespace Azurin\Framework\Services;

class Cookie
{
    // Set options on consruct
    public function __construct(
        protected $options = []
    ){}

    // Set
    public function set($id, $data)
    {
        setcookie($id, $data, $this->options);
    }

    // Get
    public function get($id)
    {
        if (! empty($_COOKIE[$id])) {
            $data = $_COOKIE[$id];
        } else {
            $data = null;
        }
        
        return $data;
    }
}