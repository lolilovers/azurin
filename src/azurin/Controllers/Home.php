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
            'desc'      => 'Simple PHP Framework'
        ];
        echo $this->view('home/index', $data);
    }
}