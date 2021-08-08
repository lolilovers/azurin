<?php

	/**
	 * This variable tells if the Reloader is enabled or not.
	 * Remember to NEVER deploy or active this feature on prod.
	 */
	$ENABLED = true;


	/**
	 * For additional security, input your development site address 
	 * to recognize in case of accidental migration into production.
	 * By default, only locahost is enabled to run this script.
	 */
	$ENABLED_HOSTS = [
		'::1',
		'localhost',
		'localhost:8080',
		'127.0.0.1',
	];

	/**
	 * This variable must contain your project root absolute
	 * path with a trailing slash. The Watch and Ignore paths
	 * will be relative to this one.
	 */
	$PROJECT_ROOT  = __DIR__ . '\..\..\..\\';

	/**
	 * This variable must contain the list of files/folders
	 * that you want to watch. The application will be reloaded
	 * when detected some change on those references. All the
	 * paths must be relative to $PROJECT_ROOT var.
	 */
	$WATCH = [
		"."
	];

	/**
	 * Here goes the folders/files that you want the Reloader
	 * to ignore. Add only folders/files that are connected to
	 * the paths you added to $WATCH, otherwise, there is no
	 * needing to specify them. All the paths must be relative
	 * to the $PROJECT_ROOT var.
	 */
	$IGNORE = [

	];

	// ---------------------- Dont Edit It ----------------------

	require_once __DIR__ . "/Reloader/HotReloaderSSE.php";