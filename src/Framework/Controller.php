<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace Src\Framework;

use Src\Framework\TemplateEngine\TemplateEngine;
use Src\Framework\TemplateEngine\Loader\FilesystemLoader;
use Src\Framework\Services\Encryption;
use Src\Framework\Services\Session;
use Src\Framework\Services\Input;
use Src\Framework\Services\NativeRenderer;

class Controller
{
    public function __construct(
        protected $view = '',
        protected $render = [],
        protected $model = '',
        protected $cache = ''
    ){}

    // Renderer service
    public function view($view, $data = [], $viewEngine = false)
    {
        // View & cache path
        $this->render['viewPath']   = SRCPATH . 'Views/';
        $this->render['cachePath']  = SRCPATH . 'Storage/cache/';
        
        // Save data
        if(! empty($data) && is_array($data)) {
            $this->render['data']   = $data;
        }
        else {
            $this->render['data']   = [];
        }
        $this->render['view']       = $view;
        $this->render['viewEngine'] = $viewEngine;
        unset($view);
        unset($data);
        unset($viewEngine);
        
        // Render with template engine
        if($this->render['viewEngine']) {
            $TemplateEngineLoader   = new FilesystemLoader($this->render['viewPath']);
            $TemplateEngine         = new TemplateEngine([
                "loader"            => $TemplateEngineLoader,
                "partials_loader"   => $TemplateEngineLoader
            ]);
            $this->view = $TemplateEngine->render($this->render['view'], $this->render['data']);
        }
        // Render with native renderer
        else {
            $native     = new NativeRenderer();
            $this->view = $native->render($this->render['view'], $this->render['data']);
        }
        
        // Save rendered view
        if ($this->render['view'] == $this->cache) {
            $cacheName      = CACHE_PREFIX . '_' . md5($this->render['view']) . '.html';
            $cacheFile      = $this->render['cachePath'] . $cacheName;
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
        $cachePath      = SRCPATH . '/Storage/cache/' . $cacheName;
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
        return $this->view($view, $this->render['data'], $this->render['viewEngine']);
    }
    
    // Model loader
    public function model($model)
    {
        $model          = 'Src\Models\\'.$model;
        $this->model    = new $model;
        
        return $this->model;
    }

    // Form action service
    public function input()
    {
        return new Input();
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