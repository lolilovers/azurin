<?php

// Error logger
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('display_errors', DEV_MODE);
ini_set('error_log', SRCPATH . 'Storage/log/' . date('Y-m-d') . '.log');

// Production error handler
function prodErrHandler($errno, $errstr, $errfile, $errline) {
    // Save log
    $log = "Error $errno : $errstr in $errfile on line $errline";
    error_log($log);
    
    return send_500();
}

// Set production error handler
if (DEV_MODE == false) {
    set_error_handler('prodErrHandler');
}