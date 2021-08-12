<?php

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
        if ($method == 'view'
            || $method == 'cache'
            || $method == 'redirect'
            || $method == 'model'
        ){
            $this->request  = [
                0 => $controller,
                1 => DEFAULT_METHOD
            ];
        }

        return $this->request;
    }

    // After acessing controller
    public function after($res)
    {
        // Do something here
        $this->response = $res;

        return $this->response;
    }
}
