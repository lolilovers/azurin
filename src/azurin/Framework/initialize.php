<?php

/**
 * ===========================
 * Bootstrapper
 * ===========================
 */

// Define src path
define('SRCPATH', ROOTPATH . 'azurin/');

// Autoloader
require_once SRCPATH . 'Framework/Common/autoloader.php';

// Start app
$app = new Azurin\Framework\Azurin();

return $app->listen();