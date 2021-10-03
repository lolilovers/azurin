<?php

// Parse the .env file and send to the $_ENV variable
$dotEnv = new Azurin\Framework\DotEnv\Loader(ROOTPATH . '.env');
$dotEnv->parse();
$dotEnv->toEnv();

// App settings
define('URL', $_ENV['URL']);
define('HTTPS_FORCE', $_ENV['HTTPS_FORCE']);

// Route settings
define('DEFAULT_CONTROLLER', $_ENV['DEFAULT_CONTROLLER']);
define('DEFAULT_METHOD', $_ENV['DEFAULT_METHOD']);

// Database settings
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

// Cache settings
define('CACHE_DEFAULT_EXPIRE', $_ENV['CACHE_DEFAULT_EXPIRE']);

// Development mode
define('DEV_MODE', $_ENV['DEV_MODE']);

// Hot reload
define('HR_ENABLE', $_ENV['HR_ENABLE']);
define('HR_WATCHER', $_ENV['HR_WATCHER']);

// Content security policy
define('CSP_ENABLE', $_ENV['CSP_ENABLE']);
define('CSP_FILE', $_ENV['CSP_FILE']);

// Encryption
define('ENCRYPTION_KEY', $_ENV['ENCRYPTION_KEY']);

// Enable/disable template engine by default
define('TED_ENABLE', $_ENV['TED_ENABLE']);

// Session path
ini_set('session.save_path', SRCPATH . '/Storage/session');