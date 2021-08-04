<?php

/**
 * ===========================
 * Config & Bootstrapper
 * ===========================
 */

// App settings
define('URL', 'http://localhost/');
define('HTTPS_FORCE', false);

// Route settings
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_METHOD', 'index');

// Database settings
define('DB_SERVER', 'localhost');
define('DB_NAME', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');

// Cache settings
define('CACHE_PREFIX', 'cached');
define('CACHE_DEFAULT_EXPIRE', 60);

// Display error
define('ERR_DISPLAY', true);

// Autoloader
spl_autoload_register(function ($class) {
    require_once SRCPATH . $class . '.php';
});

// Start app
$app = new Framework\Azurin();
$app->listen();