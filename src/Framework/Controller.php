<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace Src\Framework;

use Src\Framework\TemplateEngine\TemplateEngine;
use Src\Framework\TemplateEngine\Loader\FilesystemLoader;
use Src\Framework\Encryption;
use Src\Framework\Session;

class Controller
{
    public function __construct(
        protected $view = '',
        protected $viewData = [],
        protected $viewEngine = true,
        protected $model = '',
        protected $cache = ''
    ){}

    // Renderer service
    public function view($view, $data = [], $viewEngine = true)
    {
        // View path
        $viewPath   = SRCPATH . 'Views/';
        $cachePath  = SRCPATH . 'Storage/cache/';

        // Save data
        if(! empty($data)) {
            if(is_array($data)) {
                $this->viewData = $data;
                unset($data);
            }
        }
        else {
            $this->viewData = [];
        }
        $this->viewEngine = $viewEngine;
        unset($viewEngine);
        
        // Render with template engine
        if($this->viewEngine) {
            $TemplateEngineLoader   = new FilesystemLoader($viewPath);
            $TemplateEngine         = new TemplateEngine([
                "loader"            => $TemplateEngineLoader,
                "partials_loader"   => $TemplateEngineLoader
            ]);
            ob_start();
            echo $TemplateEngine->render($view, $this->viewData);
            $this->view = ob_get_contents();
            ob_end_clean();
        }
        // Render without template engine
        else {
            ob_start();
            include $viewPath . $view . '.html';
            $this->view = ob_get_contents();
            ob_end_clean();
        }
        
        // Save rendered view
        if ($view == $this->cache) {
            $cacheName      = CACHE_PREFIX . '_' . md5($view) . '.html';
            $cacheFile      = $cachePath . $cacheName;
            $cacheFactory   = fopen($cacheFile, 'w');
            fwrite($cacheFactory, $this->view);
            fclose($cacheFactory);
        }
        
        // Return rendered view
        return $this->view;
    }

    // Cache service
    public function cache($cache = '', $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache file
        $this->cache    = $cache;
        $cacheName      = CACHE_PREFIX . '_' . md5($cache) . '.html';
        $cachePath      = SRCPATH.'/Storage/cache/'.$cacheName;
        // Check cache
        if (file_exists($cachePath) && (time() - $expire < filemtime($cachePath))) {
            // Load cache and stop execution
            require_once($cachePath);
            
            exit();
        }
    }

    // View extender
    public function merge($view)
    {
        return $this->view($view, $this->viewData, $this->viewEngine);
    }
    
    // Model loader
    public function model($model)
    {
        $model          = 'Src\Models\\'.$model;
        $this->model    = new $model;
        
        return $this->model;
    }

    // Form action service
    public function get($var)
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
        
        // Return
        return $var;
    }

    // Redirect
    public function redirect($redirect)
    {
        return header('Location: ' . URL . $redirect);
    }

    // Session service
    public function session()
    {
        return new Session();
    }

    // Response JSON data
    public function json($data = '')
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Encryption service
    public function encryption()
    {
        $key = ENCRYPTION_KEY;
        $enc = new Encryption($key);
        
        return $enc;
    }
}