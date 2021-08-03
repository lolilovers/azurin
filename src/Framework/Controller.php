<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace App\Framework;

class Controller
{
    private $session_active = false;
    protected $view;
    protected $view_data;
    protected $model;
    // Renderer
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
    // Load other view
    public function merge($view)
    {
        if(! empty($this->view_data))
        {
            if(is_array($this->view_data))
            {
                extract($this->view_data, EXTR_OVERWRITE);
            }
        }
        ob_start();
        require_once SRCPATH.'Views/'.$view.'.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    // Model
    public function model($model)
    {
        require_once SRCPATH.'Models/'.$model.'.php';
        $this->model = 'App\Models\\'.$model;
        $this->model = new $this->model;
        return $this->model;
    }
    // Redirect
    public function redirect($redirect)
    {
        return header('Location: '.URL.'/'.$redirect);
    }
    // data binary encoded session
    public function session($type , $id = '', $data = '')
    {
        if($type == 'destroy')
        {
            // start the session
            if(! $this->session_active)
            {
                session_start();
                $this->session_active = true;
            }
            // destroy session
            return session_destroy();
        }
        else if($type == 'set')
        {
            // start the session
            if(! $this->session_active)
            {
                session_start();
                $this->session_active = true;
            }
            // encode data
            $id     = base64_encode($id);
            $data   = base64_encode($data);
            // set data
            return $_SESSION[$id] = $data;
        }
        else if($type == 'get')
        {
            // start the session
            if(! $this->session_active)
            {
                session_start();
                $this->session_active = true;
            }
            // decode data
            $id     = base64_encode($id);
            if(! empty($_SESSION[$id]))
            {
                $data   = base64_decode($_SESSION[$id]);    
                // send back to Controller::method
                return $data;
            }
        }
    }
    /**
     * Cache function
     * 
     * this: place begin of controller method
     * end: place before end of controller method
     */
    public function cache($type, $id, $expire = CACHE_DEFAULT_EXPIRE)
    {
		// Cache name
		$cache_name = CACHE_PREFIX."_".base64_encode($id);
		// Cache file location
		$cachefile  = SRCPATH."/Storage/cache/".$cache_name.".html";
		// Before
		if($type == 'this')
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
}