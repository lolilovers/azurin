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
        if(! empty($data))
        {
            if(is_array($data))
            {
                $this->view_data = $data;
                unset($data);
                extract($this->view_data, EXTR_OVERWRITE);
            }
        }
        ob_start();
        require_once SRCPATH.'Views/'.$view.'.php';
        $this->view = ob_get_contents();
        ob_end_clean();
        return $this->view;
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
        if(! $this->session_active)
        {
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
    
    /**
     * Cache service
     * 
     * start: place begin of controller method
     * end: place before end of controller method
     */
    public function cache($type = 'end', $id = '', $expire = CACHE_DEFAULT_EXPIRE)
    {
		// Cache name
        if(! $id)
        {
            $id = $this->cache;
        }
        $this->cache = $id;
		$cache_name = CACHE_PREFIX."_".md5($id);
		// Cache file location
		$cachefile  = SRCPATH."/Storage/cache/".$cache_name.".html";
		// Before
		if($type == 'start')
		{
			if (file_exists($cachefile) && (time() - $expire < filemtime($cachefile)))
			{
			    require_once($cachefile);
			    exit;
			}
			ob_start();
		}
		// After
		else if($type == 'end')
		{
			$create_cache = fopen($cachefile, 'w');
			fwrite($create_cache, ob_get_contents());
			fclose($create_cache);
			ob_end_flush();
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