<?php

/**
 * ===========================
 * Input
 * ===========================
 */

namespace Azurin\Framework\Services;

class Input
{
    public function vars($var)
    {
        if (! empty($_GET[$var]) && ! empty($_POST[$var])) {
            // GET & POST in same time
            $var = [
                'get'   => $_GET[$var],
                'post'  => $_POST[$var]
            ];
        } elseif (! empty($_GET[$var])) {
            // GET
            $var = $_GET[$var];
        } elseif (! empty($_POST[$var])) {
            // POST
            $var = $_POST[$var];
        } else {
            // NULL
            $var = null;
        }
        
        return $var;
    }

    public function get($var)
    {
        if (! empty($_GET[$var])) {
            $var = $_GET[$var];
        } else {
            $var = null;
        }

        return $var;
    }

    public function post($var)
    {
        // POST
        if (! empty($_POST[$var])) {
            $var = $_POST[$var];
        } else {
            $var = null;
        }

        return $var;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}