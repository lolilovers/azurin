<?php

namespace Controllers;

use Framework\Controller;

class Home extends Controller
{
    public function index()
    {
        $data   = [
            'name'      => 'Azurin',
            'version'   => AZURIN_VERSION,
            'desc'      => 'PHP Micro Framework'
        ];
        echo $this->view('home/index', $data);
    }
}