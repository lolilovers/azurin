<?php

namespace App\Controllers;

use App\Framework\Controller;

class Home extends Controller
{
    public function index()
    {
        echo $this->view('home/index');
    }
}