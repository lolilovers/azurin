<?php

/**
 * ===========================
 * Autoloader
 * ===========================
 */

// Autoload vendor
require_once ROOTPATH . 'vendor/autoload.php';

// Load framework configuration
require_once SRCPATH . 'Framework/Config.php';

// Autoload framework
spl_autoload_register(function ($class){
    require_once ROOTPATH . $class . '.php';
});
