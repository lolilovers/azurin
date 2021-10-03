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

// Redirect to previous page
if (! function_exists('redirectBack'))
{
    function redirectBack()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // Using HTTP referer
            return header('Location: ' . $_SERVER['HTTP_REFERER']);
            
            exit();
        } else {
            // Using history
            echo '<script>window.history.back()</script>';
        }
    }
}

// Escape using HTML special chars
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
    function view($file, $data = [], $viewEngine = TED_ENABLE)
    {
        // Setup
        $viewPath   = SRCPATH . 'Views/';
        $cachePath  = SRCPATH . 'Storage/cache/';
        // Renderer
        if (! $viewEngine) {
            // Native Renderer
            $native     = new Azurin\Framework\Services\NativeRenderer($viewPath);
            $view       = $native->render($file, $data);
        } else {
            // Template Engine
            $templateEngineLoader   = new Azurin\Framework\TemplateEngine\Loader\FilesystemLoader($viewPath);
            $template               = new Azurin\Framework\TemplateEngine\TemplateEngine([
                "loader"            => $templateEngineLoader,
                "partials_loader"   => $templateEngineLoader
            ]);
            $view   = $template->render($file, $data);
        }
        // Save rendered view
        $cacheFactory   = new Azurin\Framework\Services\Cache($cachePath);
        $cacheFactory->create($file, $view);

        return $view;
    }
}

// Cache loader
if (! function_exists('cache'))
{
    function cache($cache, $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache path
        $cachePath      = SRCPATH . 'Storage/cache/';
        // Load cache
        $cacheLoader    = new Azurin\Framework\Services\Cache($cachePath);

        return $cacheLoader->load($cache, $expire);
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

// Session
if (! function_exists('session'))
{
	function session()
	{
		return new Azurin\Framework\Services\Session();
	}
}

// Cookie
if (! function_exists('cookie'))
{
	function cookie()
	{
		return new Azurin\Framework\Services\Cookie($options = []);
	}
}
