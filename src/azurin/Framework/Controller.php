<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace Azurin\Framework;

use Azurin\Framework\TemplateEngine\Loader\FilesystemLoader;
use Azurin\Framework\HotReload\Reloader\HotReloader;
use Azurin\Framework\TemplateEngine\TemplateEngine;
use Azurin\Framework\Services\NativeRenderer;
use Azurin\Framework\Services\Encryption;
use Azurin\Framework\Services\Session;
use Azurin\Framework\Services\Cookie;
use Azurin\Framework\Services\Output;
use Azurin\Framework\Services\Cache;
use Azurin\Framework\Services\Files;
use Azurin\Framework\Services\Input;
use Azurin\Framework\CSP\CSPBuilder;

class Controller
{
    protected $cache = '';
    protected $model = '';
    protected $render = [];
    protected $view = '';

    public function __construct()
    {
        // Content security policy
        $this->csp();

        // Hot reloader
        $this->hotReload();
    }

    // Renderer service
    public function view($view, $data = [], $viewEngine = false)
    {
        // View & cache path
        $this->render['viewPath']   = SRCPATH . 'Views/';
        $this->render['cachePath']  = SRCPATH . 'Storage/cache/';
        
        // Save data
        if (! empty($data) && is_array($data)) {
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
        if ($this->render['viewEngine']) {
            $templateEngineLoader   = new FilesystemLoader($this->render['viewPath']);
            $template               = new TemplateEngine([
                "loader"            => $templateEngineLoader,
                "partials_loader"   => $templateEngineLoader
            ]);
            $this->view = $template->render($this->render['view'], $this->render['data']);
        } else {
            // Render with native renderer
            $native     = new NativeRenderer($this->render['viewPath']);
            $this->view = $native->render($this->render['view'], $this->render['data']);
        }
        
        // Save rendered view
        if ($this->render['view'] == $this->cache) {
            $cacheFactory = new Cache($this->render['cachePath']);
            $cacheFactory->create($this->render['view'], $this->view);
        }
        
        // Return rendered view
        return $this->view;
    }

    // Cache service
    public function cache($cache, $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache file
        $this->cache    = $cache;
        $cachePath      = SRCPATH . 'Storage/cache/';
        
        // Load cache
        $cacheLoader = new Cache($cachePath);

        return $cacheLoader->load($cache, $expire);
    }

    // View extender
    public function merge($view)
    {
        return $this->view($view, $this->render['data'], $this->render['viewEngine']);
    }
    
    // Model loader
    public function model($model)
    {
        $this->model  = 'Azurin\Models\\' . $model;
        
        return new $this->model;
    }

    // Redirect
    public function redirect($redirect)
    {
        return header('Location: ' . URL . $redirect);
    }

    // Hot reload service
    public function hotReload()
    {
        if (HR_ENABLE && DEV_MODE) {
            return new HotReloader(HR_WATCHER);
        }
    }

    // Output service
    public function output()
    {
        return new Output();
    }

    // Input service
    public function input()
    {
        return new Input();
    }

    // Files service
    public function files()
    {
        return new Files();
    }

    // Cookie service
    public function cookie($options = [])
    {
        return new Cookie($options);
    }

    // Session service
    public function session()
    {
        return new Session();
    }

    // Encryption service
    public function encryption()
    {
        $key = ENCRYPTION_KEY;
        
        return new Encryption($key);
    }

    // Content security policy service
    public function csp()
    {
        if (CSP_ENABLE) {
            $csp = CSPBuilder::fromFile(ROOTPATH . CSP_FILE);

            return $csp->sendCSPHeader();
        }
    }
}