<?php

namespace Azurin\Controllers;

use Azurin\Framework\CSRF\CSRF AS csrf;
use Azurin\Framework\Controller;

class Home extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
