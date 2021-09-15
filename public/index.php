<?php

// ---- Front Controller ----

// Define root project directory
define('ROOTPATH', __DIR__.'/..//');

// Bootstrap the app
$app = require_once ROOTPATH . 'azurin/Framework/initialize.php';

// Hot Reloader (development mode)
if (HR_ENABLE && DEV_MODE) {
    new Azurin\Framework\HotReload\Reloader\HotReloader(HR_WATCHER);
}

// Send output to browser
echo $app;
