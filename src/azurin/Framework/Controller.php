<?php

// ---- Base Controller ----

namespace Azurin\Framework;

use Azurin\Framework\TemplateEngine\Loader\FilesystemLoader;
use Azurin\Framework\HotReload\Reloader\HotReloader;
use Azurin\Framework\TemplateEngine\TemplateEngine;
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
    protected $render  = [];
    protected $cache   = '';
    protected $model   = '';
    protected $view    = '';
    protected $encryption;
    protected $hotReload;
    protected $response;
    protected $session;
    protected $request;
    protected $cookie;
    protected $files;
    protected $csp;

    public function __construct()
    {
        // Content security policy
        if (CSP_ENABLE) {
            $this->csp = CSPBuilder::fromFile(ROOTPATH . CSP_FILE);
            $this->csp->sendCSPHeader();
        }

        // Encryption
        $this->encryption   = new Encryption(ENCRYPTION_KEY);

        // Hot reload
        if (HR_ENABLE && DEV_MODE) {
            $this->hotReload = new HotReloader(HR_WATCHER);
        }

        // Request & response
        $this->response = new Output();
        $this->request  = new Input();
        $this->files    = new Files();
        
        // Session & cookie 
        $this->cookie   = new Cookie($options = []);
        $this->session  = new Session();
    }

    // View renderer
    protected function view($view, $data = [], $viewEngine = TED_ENABLE)
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
        
        if ($this->render['viewEngine']) {
            // Render using template engine
            $templateEngineLoader   = new FilesystemLoader($this->render['viewPath']);
            $template               = new TemplateEngine([
                "loader"            => $templateEngineLoader,
                "partials_loader"   => $templateEngineLoader
            ]);
            $this->view = $template->render($this->render['view'], $this->render['data']);
        } else {
            // Render using native renderer
            $this->view = view($this->render['view'], $this->render['data']);
        }
        
        // Save rendered view
        if ($this->render['view'] == $this->cache) {
            $cacheFactory = new Cache($this->render['cachePath']);
            $cacheFactory->create($this->render['view'], $this->view);
        }
        
        // Return rendered view
        return $this->view;
    }

    // Cache loader
    protected function cache($cache, $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache path
        $this->cache    = $cache;
        $cachePath      = SRCPATH . 'Storage/cache/';
        // Load cache
        $cacheLoader = new Cache($cachePath);

        return $cacheLoader->load($cache, $expire);
    }

    // Model loader
    protected function model($model)
    {
        $this->model = model($model);

        return $this->model;
    }
}