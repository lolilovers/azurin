<?php

// Redirect
if (! function_exists('redirect'))
{
    function redirect($to, $redirectJS = false)
    {
        if ($redirectJS) {
            // Using javascript redirect
            echo '<script>window.location.replace("'. URL . $to . '")</script>';
        } else {
            // Using HTTP redirect
            return header('Location: ' . URL . $to);
        }
    }
}

// HTML special chars
if (! function_exists('h'))
{
    function h($string = null)
    {
        if ($string != null) {
            return htmlspecialchars($string);
        }
    }
}

// Model loader
if (! function_exists('model'))
{
    function model($model)
    {
        $model  = 'Azurin\Models\\' . $model;
        
        return new $model;
    }
}

// Javascript console.log
if (! function_exists('console'))
{
    function console($log)
    {
        echo '<script>console.log("'. $log .'")</script>';
    }
}