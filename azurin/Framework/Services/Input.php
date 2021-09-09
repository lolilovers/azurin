<?php

namespace Azurin\Framework\Services;

class Input
{
    // Get vars from client request
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

    // Same as $_GET
    public function get($var)
    {
        if (! empty($_GET[$var])) {
            $var = $_GET[$var];
        } else {
            $var = null;
        }

        return $var;
    }

    // Same as $_POST
    public function post($var)
    {
        if (! empty($_POST[$var])) {
            $var = $_POST[$var];
        } else {
            $var = null;
        }

        return $var;
    }

    // Get request method
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    // Detect AJAX request
    public function isAjax()
    {
        if (! empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Detected
            return true;
        } else {
            // Not detected
            return false;
        }
    }
}