<?php

namespace Controllers;

use Framework\Controller;

class Home extends Controller
{
    public function index()
    {
        echo $this->view('home/index');
    }
}