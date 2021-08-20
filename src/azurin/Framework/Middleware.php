<?php

// ---- Middleware ----

namespace Azurin\Framework;

class Middleware
{
    protected $response;
    protected $request;

    // Before accessing controller
    public function before($req = [])
    {
        // Do something here
        $this->request  = $req;
        $controller     = isset($req[0]) ? $req[0] : DEFAULT_CONTROLLER;
        $method         = isset($req[1]) ? $req[1] : DEFAULT_METHOD;
        if ($method == 'view' || $method == 'cache'){
            http_response_code(403);
            require_once SRCPATH . 'Framework/Views/errors/403.html';
            
            die();
        }

        return $this->request;
    }

    // After accessing controller
    public function after($res)
    {
        // Do something here
        $this->response = $res;

        return $this->response;
    }
}