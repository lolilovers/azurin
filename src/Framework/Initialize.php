<?php

/**
 * ===========================
 * Bootstrapper
 * ===========================
 */

// Load required files
require_once SRCPATH.'/Framework/Config.php';
require_once SRCPATH.'/Framework/Controller.php';
require_once SRCPATH.'/Framework/Database.php';
require_once SRCPATH.'/Framework/Model.php';
require_once SRCPATH.'/Framework/Azurin.php';

// Run the application
use App\Framework\Azurin;
$app = new Azurin();
$app->start();