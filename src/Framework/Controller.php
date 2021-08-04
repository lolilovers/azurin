<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace Framework;

class Controller
{
    private $session_active = false;
    protected $view;
    protected $view_data;
    protected $model;
    protected $cache;
    
    // Renderer service
    public function view($view, $data = [])
    {
        // Save data
        if(! empty($data)) {
            if(is_array($data)) {
                $this->view_data = $data;
                unset($data);
                extract($this->view_data, EXTR_OVERWRITE);
            }
        }
        // Render
        ob_start();
        include SRCPATH.'Views/'.$view.'.php';
        $this->view = ob_get_contents();
        ob_end_clean();
        // if cache enabled
        if ($view == $this->cache) {
            // cache file
            $cache_name     = CACHE_PREFIX."_".md5($view);
		    $cachefile      = SRCPATH."/Storage/cache/".$cache_name.".html";
            // save cache
            $create_cache = fopen($cachefile, 'w');
			fwrite($create_cache, $this->view);
			fclose($create_cache);
        }
        // return output
        return $this->view;
    }

    // Cache service
    public function cache($id = '', $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache file
        $this->cache    = $id;
        $cache_name     = CACHE_PREFIX."_".md5($id);
        $cachefile      = SRCPATH."/Storage/cache/".$cache_name.".html";
        // check cache
        if (file_exists($cachefile) && (time() - $expire < filemtime($cachefile))) {
            // load cache and stop execution
            require_once($cachefile);
            exit;
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
        return header('Location: '.URL.'/'.$redirect);
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
        if($type == 'destroy')
        {
            // destroy session
            return session_destroy();
        }
        // set
        else if($type == 'set')
        {
            // set data
            return $_SESSION[$id] = $data;
        }
        // get
        else if($type == 'get')
        {
            if(! empty($_SESSION[$id]))
            {
                // get data
                $data   = $_SESSION[$id];    
                return $data;
            }
        }
    }

    // Form action service
    public function get($var)
    {
        if (! empty($_GET[$var]) && ! empty($_POST[$var]))
        {
            $var = [
                'get'   => $_GET[$var],
                'post'  => $_POST[$var]
            ];
        }
        else if (! empty($_GET[$var]))
        {
            $var = $_GET[$var];
        }
        else if (! empty($_POST[$var]))
        {
            $var = $_POST[$var];
        }
        else
        {
            $var = null;
        }
        return $var;
    }
}