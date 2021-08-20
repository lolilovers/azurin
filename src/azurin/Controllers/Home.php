<?php

namespace Azurin\Controllers;

use Azurin\Framework\CSRF\CSRF AS csrf;
use Azurin\Framework\Controller;

class Home extends Controller
{
    public function index()
    {
        $data   = [
            'name'      => 'Azurin',
            'version'   => AZURIN_VERSION,
            'desc'      => 'Simple PHP Framework',
            'url'       => URL
        ];
        
        return $this->view('hello_world', $data);
    }
}