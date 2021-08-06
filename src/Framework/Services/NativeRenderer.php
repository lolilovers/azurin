<?php

namespace Src\Framework\Services;

class NativeRenderer
{
    protected $render = [];

    public function render($view, $data = [])
    {
        // Path
        $this->render['viewPath']   = SRCPATH . 'Views/';
        $this->render['view']       = $view;

        // Save data from request
        if(! empty($data) && is_array($data)) {
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
        include $this->render['viewPath'] . $this->render['view'] . '.html';
        $this->render['output'] = ob_get_contents();
        ob_end_clean();

        // Return rendered output
        return $this->render['output'];
    }
}