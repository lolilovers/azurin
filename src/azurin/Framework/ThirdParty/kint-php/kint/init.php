<?php

use Kint\Kint;
use Kint\Utils;

if (\defined('KINT_DIR')) {
    return;
}

if (\version_compare(PHP_VERSION, '5.3') < 0) {
    throw new Exception('Kint 3.0 requires PHP 5.3 or higher');
}

\define('KINT_DIR', __DIR__);
\define('KINT_WIN', DIRECTORY_SEPARATOR !== '/');
\define('KINT_PHP56', (\version_compare(PHP_VERSION, '5.6') >= 0));
\define('KINT_PHP70', (\version_compare(PHP_VERSION, '7.0') >= 0));
\define('KINT_PHP72', (\version_compare(PHP_VERSION, '7.2') >= 0));
\define('KINT_PHP73', (\version_compare(PHP_VERSION, '7.3') >= 0));
\define('KINT_PHP74', (\version_compare(PHP_VERSION, '7.4') >= 0));

// Dynamic default settings
Kint::$file_link_format = \ini_get('xdebug.file_link_format');
if (isset($_SERVER['DOCUMENT_ROOT'])) {
    Kint::$app_root_dirs = array(
        $_SERVER['DOCUMENT_ROOT'] => '<ROOT>',
        \realpath($_SERVER['DOCUMENT_ROOT']) => '<ROOT>',
    );
}

Utils::composerSkipFlags();

if ((!\defined('KINT_SKIP_FACADE') || !KINT_SKIP_FACADE) && !\class_exists('Kint')) {
    \class_alias('Kint\\Kint', 'Kint');
}

if (!\defined('KINT_SKIP_HELPERS') || !KINT_SKIP_HELPERS) {
    require_once __DIR__.'/init_helpers.php';
}
