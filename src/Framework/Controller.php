<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace Framework;

class Controller
{
    public function __construct(
        private $session_active = false,
        protected $view = '',
        protected $view_data = [],
        protected $model = '',
        protected $cache = ''
    ){}

    // Renderer service
    public function view($view, $data = [])
    {
        // View path
        $viewpath   = SRCPATH . 'Views';
        $cachepath  = SRCPATH . 'Storage/cache/';

        // Twig template engine
        $loader = new \Twig\Loader\FilesystemLoader($viewpath);
        $twig   = new \Twig\Environment($loader);

        // Save data
        if(! empty($data)) {
            if(is_array($data)) {
                $this->view_data = $data;
                unset($data);
            }
        }
        else {
            $this->view_data = [];
        }
        
        // Render
        ob_start();
        echo $twig->render($view . '.html', $this->view_data);
        $this->view = ob_get_contents();
        ob_end_clean();
        
        // When cache enabled
        if ($view == $this->cache) {
            // Cache file
            $cache_name     = CACHE_PREFIX."_".md5($view);
            $cachefile      = $cachepath.$cache_name.".html";
            
            // Save cache
            $create_cache = fopen($cachefile, 'w');
            fwrite($create_cache, $this->view);
            fclose($create_cache);
        }
        
        // Return output
        return $this->view;
    }

    // Cache service
    public function cache($cache = '', $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache file
        $this->cache    = $cache;
        $cache_name     = CACHE_PREFIX . '_' . md5($cache);
        $cachefile      = SRCPATH."/Storage/cache/".$cache_name.".html";
        // check cache
        if (file_exists($cachefile) && (time() - $expire < filemtime($cachefile))) {
            // load cache and stop execution
            require_once($cachefile);
            exit();
        }
    }

    // View extender
    public function merge($view)
    {
        return $this->view($view, $this->view_data);
    }
    
    // Model
    public function model($model)
    {
        $this->model = 'Models\\'.$model;
        $this->model = new $this->model;
        return $this->model;
    }
    
    // Redirect
    public function redirect($redirect)
    {
        return header('Location: ' . URL . $redirect);
    }
    
    // Session service
    public function session($type , $id = '', $data = '')
    {
        // start the session
        if(! $this->session_active) {
            ini_set('session.save_path', SRCPATH . '/Storage/session');
            session_start();
            $this->session_active = true;
        }
        // destroy
        if($type == 'destroy') {
            // destroy session
            return session_destroy();
        }
        // set
        else if($type == 'set') {
            // set data
            return $_SESSION[$id] = $data;
        }
        // get
        else if($type == 'get') {
            if(! empty($_SESSION[$id])) {
                // get data
                $data   = $_SESSION[$id];    
                return $data;
            }
        }
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
}