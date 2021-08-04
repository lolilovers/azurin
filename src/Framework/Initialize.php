<?php

/**
 * ===========================
 * Bootstrapper
 * ===========================
 */

// Autoloader
require_once SRCPATH . 'Framework/Autoloader.php';

// Start app
$app = new Framework\Azurin();
$app->listen();