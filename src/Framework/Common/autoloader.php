<?php

/**
 * ===========================
 * Autoloader
 * ===========================
 */

// Autoload vendor
if(file_exists(ROOTPATH . 'vendor/autoload.php'))
{
    require_once ROOTPATH . 'vendor/autoload.php';
}

// Autoload framework
spl_autoload_register(function ($class){
    require_once ROOTPATH . $class . '.php';
});

// Non class loader
require_once SRCPATH . 'Framework/Common/config.php';
require_once SRCPATH . 'Framework/Common/logger.php';
require_once SRCPATH . 'Framework/Database/functions.php';