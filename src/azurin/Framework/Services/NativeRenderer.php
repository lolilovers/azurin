<?php

namespace Azurin\Framework\Services;

class NativeRenderer
{
    protected $render = [];

    public function __construct(
        protected $viewPath,
        protected $viewExtension = '.php'
    ){}

    public function render($view, $data = [])
    {
        // Path
        $this->render['viewPath']   = $this->viewPath;
        $this->render['extension']  = $this->viewExtension;
        $this->render['view']       = $view;

        // Save data from request
        if (! empty($data) && is_array($data)) {
            $this->render['data']   = $data;
        }
        
        // Unset data from request
        unset($view);
        unset($data);
        
        // Extract saved data
        if (! empty($this->render['data']) && is_array($this->render['data'])) {
            extract($this->render['data'], EXTR_OVERWRITE);
        }
        
        // Render
        ob_start();
        include $this->render['viewPath'] . $this->render['view'] . $this->render['extension'];
        $this->render['output'] = ob_get_contents();
        ob_end_clean();

        // Return rendered output
        return $this->render['output'];
    }

    public function extend($view)
    {
        return $this->render($view, $this->render['data']);
    }
}