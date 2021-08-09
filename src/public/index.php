<?php

/**
 * ===========================
 * Front Controller
 * ===========================
 */

// Define root project directory
define('ROOTPATH', __DIR__.'/..//');

// Get and send content to browser
$content = require_once ROOTPATH . 'azurin/Framework/initialize.php';
echo $content;