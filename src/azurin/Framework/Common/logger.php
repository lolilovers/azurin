<?php

// Logger
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('display_errors', DEV_MODE);

// Path
ini_set('error_log', SRCPATH . 'Storage/log/' . date('Y-m-d') . '.log');