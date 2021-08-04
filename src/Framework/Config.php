<?php

/**
 * ===========================
 * Configuration
 * ===========================
 */

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(SRCPATH . '../');
$dotenv->load();

// App settings
define('URL', $_ENV['URL']);
$https = $_ENV['HTTPS_FORCE'] == 'true' ? true : false;
define('HTTPS_FORCE', $https);

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
$cacheexpire = (int)$_ENV['CACHE_DEFAULT_EXPIRE'];
define('CACHE_DEFAULT_EXPIRE', $cacheexpire);

// Development mode
$dispe = $_ENV['DEV_MODE'] == 'true' ? true : false;
Kint::$enabled_mode = $dispe;
define('ERR_DISPLAY', $dispe);