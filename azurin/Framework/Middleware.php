<?php

namespace Azurin\Framework;

class Middleware
{
    protected $response;
    protected $request;

    // Before accessing controller
    public function before($before = [])
    {
        // Do something here
        $this->request  = $before;

        return $this->request;
    }

    // After accessing controller
    public function after($after)
    {
        // Do something here
        $this->response = $after;

        return $this->response;
    }
}