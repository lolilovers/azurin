<?php

namespace Src\Controllers;

use Src\Framework\Controller;

class Home extends Controller
{
    public function index()
    {
        $data   = [
            'name'      => 'Azurin',
            'version'   => AZURIN_VERSION,
            'desc'      => 'PHP Micro Framework'
        ];
        echo $this->view('home/index', $data, true);
    }
}