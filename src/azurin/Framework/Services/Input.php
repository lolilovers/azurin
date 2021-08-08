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
        // GET & POST in same time
        if (! empty($_GET[$var]) && ! empty($_POST[$var])) {
            $var = [
                'get'   => $_GET[$var],
                'post'  => $_POST[$var]
            ];
        }
        // GET
        else if (! empty($_GET[$var])) {
            $var = $_GET[$var];
        }
        // POST
        else if (! empty($_POST[$var])) {
            $var = $_POST[$var];
        }
        // NULL
        else {
            $var = null;
        }
        
        return $var;
    }

    public function get($var)
    {
        if (! empty($_GET[$var])) {
            $var = $_GET[$var];
        }
        else {
            $var = null;
        }

        return $var;
    }

    public function post($var)
    {
        // POST
        if (! empty($_POST[$var])) {
            $var = $_POST[$var];
        }
        else {
            $var = null;
        }

        return $var;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}