<?php

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Whoops\\' => array($vendorDir . '/filp/whoops/src/Whoops'),
    'Psr\\Log\\' => array($vendorDir . '/psr/log/Psr/Log'),
    'Kint\\' => array($vendorDir . '/kint-php/kint/src'),
);
