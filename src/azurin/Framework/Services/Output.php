<?php

namespace Azurin\Framework\Services;

class Output
{
    // Convert array to json
    public function json($data = [])
    {
        header('Content-Type: application/json');
        
        return json_encode($data);
    }

    // Create response using status than code instead
    public function respond($status = 'ok')
    {
        if ($status == 'ok') {
            $code = 200;
        } elseif ($status == 'created') {
            $code = 201;
        } elseif ($status == 'bad request') {
            $code = 400;
        } elseif ($status == 'unauthorized') {
            $code = 401;
        } elseif ($status == 'forbidden') {
            $code = 403;
        } elseif ($status == 'not found') {
            $code = 404;
        } elseif ($status == 'method not allowed') {
            $code = 405;
        } elseif ($status == 'conflict') {
            $code = 409;
        } elseif ($status == 'service unavailable') {
            $code = 503;
        } else {
            $code = 500;
        }

        return http_response_code($code);
    }
}