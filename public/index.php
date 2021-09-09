<?php

// ---- Front Controller ----

// Define root project directory
define('ROOTPATH', __DIR__.'/..//');

// Load app and send result to browser
$app = require_once ROOTPATH . 'azurin/Framework/initialize.php';
echo $app;