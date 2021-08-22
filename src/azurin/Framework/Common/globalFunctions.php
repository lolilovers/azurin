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
            $string = htmlspecialchars($string);
        }

        return $string;
    }
}

// View loader
if (! function_exists('view'))
{
    function view($file, $data = [])
    {
        $viewPath   = SRCPATH . 'Views/';
        $native     = new Azurin\Framework\Services\NativeRenderer($viewPath);
        $view       = $native->render($file, $data);

        return $view;
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

// Send forbidden page
if (! function_exists('send_403'))
{
    function send_403()
    {
        http_response_code(403);
        require_once SRCPATH.'Framework/Views/403.html';

        die();
    }
}

// Send not found page
if (! function_exists('send_404'))
{
    function send_404()
    {
        http_response_code(404);
        require_once SRCPATH.'Framework/Views/404.html';

        die();
    }
}

// Send internal server error page
if (! function_exists('send_500'))
{
    function send_500()
    {
        http_response_code(500);
        require_once SRCPATH.'Framework/Views/500.html';

        die();
    }
}