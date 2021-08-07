<?php

/**
 * ===========================
 * Logger
 * ===========================
 */

// Logger
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('display_errors', ERR_DISPLAY);

// Path
ini_set('error_log', SRCPATH . 'Storage/log/' . date('Y-m-d') . '.log');