<?php

/**
 * ===========================
 * Bootstrapper
 * ===========================
 */

// Define src path
define('SRCPATH', ROOTPATH . 'src/');

// Autoloader
require_once SRCPATH . 'Framework/Common/autoloader.php';

// Start app
$app = new Src\Framework\Azurin();
$app->listen();