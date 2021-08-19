<?php

// Autoload vendor
if (file_exists(ROOTPATH . '/../vendor/autoload.php')) {
    require_once ROOTPATH . '/../vendor/autoload.php';
}

// Autoload framework
spl_autoload_register(function ($class) {
    $namespace = explode('\\', $class);
    if ($namespace[0] == 'Azurin') {
        require_once ROOTPATH . $class . '.php';
    }
});

// Non class loader
require_once SRCPATH . 'Framework/Common/config.php';
require_once SRCPATH . 'Framework/Common/logger.php';
require_once SRCPATH . 'Framework/Database/functions.php';

// Third party dev tool loader
if(DEV_MODE) {
    require_once SRCPATH . 'Framework/ThirdParty/autoload.php';
    require_once SRCPATH . 'Framework/ThirdParty/filp/whoops/whoops.php';
}