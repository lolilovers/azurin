<?php

/**
 * ===========================
 * Configuration
 * ===========================
 */

// Parse the .env file and send to the $_ENV variable
$dotEnv = new josegonzalez\Dotenv\Loader(SRCPATH . '../.env');
$dotEnv->parse();
$dotEnv->toEnv();

// App settings
define('URL', $_ENV['URL']);
define('HTTPS_FORCE', $_ENV['HTTPS_FORCE']);

// Route settings
define('DEFAULT_CONTROLLER', $_ENV['DEFAULT_CONTROLLER']);
define('DEFAULT_METHOD', $_ENV['DEFAULT_METHOD']);

// Database settings
define('DB_SERVER', $_ENV['DB_SERVER']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

// Cache settings
define('CACHE_PREFIX', $_ENV['CACHE_PREFIX']);
$cacheexpire = $_ENV['CACHE_DEFAULT_EXPIRE'];
define('CACHE_DEFAULT_EXPIRE', $cacheexpire);

// Development mode
Kint::$enabled_mode = $_ENV['DEV_MODE'];
define('ERR_DISPLAY', $_ENV['DEV_MODE']);

// Encryption key
define('ENCRYPTION_KEY', $_ENV['ENCRYPTION_KEY']);
