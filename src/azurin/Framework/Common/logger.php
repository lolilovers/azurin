<?php

// Logger
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('display_errors', DEV_MODE);

// Path
ini_set('error_log', SRCPATH . 'Storage/log/' . date('Y-m-d') . '.log');

// Error handler in production mode
function prodErrHandler($errno, $errstr, $errfile, $errline) {
    // Save log
    $log = "Error $errno : $errstr in $errfile on line $errline";
    error_log($log);
    // Send 500 page
    include SRCPATH . 'Framework/Views/errors/500.html';
    http_response_code(500);
    die();
}

// Production mode error handler
if (DEV_MODE == false) {
    //set error handler
    set_error_handler('prodErrHandler');
}