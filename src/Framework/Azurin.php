<?php

/**
 * ===========================
 * Azurin Micro Framework Core
 * ===========================
 */

namespace App\Framework;

// Version
if(! defined('AZURIN_VER'))
{
	define('AZURIN_VER', '2.0.0');
}

Class Azurin
{
	protected $controller	= DEFAULT_CONTROLLER;
	protected $method		= DEFAULT_METHOD;
	protected $args			= [];	
	// Start program
	public function start()
	{
		// Logger
		$this->loggerInterface();
		// Request
		$request = $this->requestInterface();
		// Response
		$this->responseInterface($request);
	}
	// Logger
	public function loggerInterface()
	{
		error_reporting(E_ALL); 
		ini_set('ignore_repeated_errors', TRUE); 
		ini_set('display_errors', ERR_DISPLAY); 
		ini_set('log_errors', TRUE); 
		ini_set('error_log', SRCPATH.'Storage/logs/errors.log');	
	}
	// Request handler
	public function requestInterface()
	{
		// HTTPS
		if(HTTPS_FORCE)
		{
			if($_SERVER["HTTPS"] != "on") 
			{
				header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
				exit();
			}
		}
		// URL
		if(isset($_GET['request']))
		{
			$request	= $_GET['request'];
			$request	= filter_var($request, FILTER_SANITIZE_URL);
			$request	= explode('/', $request);
			return $request;
		}
	}
	// Response handler
	public function responseInterface($request)
	{
		// Check controller
		if(! empty($request[0]))
		{
			// controller exist
			if(file_exists(SRCPATH.'Controllers/'.$request[0].'.php'))
			{
				$this->controller = $request[0];
				unset($request[0]);
			}
			// controller not exist
			else
			{
				error_log('Controller or its method is not found: '.$request[0]);
				require_once SRCPATH.'Views/errors/notfound.php';
				return header($_SERVER["SERVER_PROTOCOL"]." 404");
				die;
			}
		}
		// Initialize controller
		require_once SRCPATH.'Controllers/'.$this->controller.'.php';
		$this->controller = 'App\Controllers\\'.$this->controller;
		$this->controller = new $this->controller;
		// Check method
		if(! empty($request[1]))
		{
			// method exist
			if(method_exists($this->controller, $request[1]))
			{
				$this->method = $request[1];
				unset($request[1]);
				// Initialize arguments
				if(! empty($request))
				{
					$this->args = array_values($request);
				}
			}
			// method not exist
			else
			{
				error_log('Controller method is not found: '.$request[1]);
				require_once SRCPATH.'Views/errors/notfound.php';
				return header($_SERVER["SERVER_PROTOCOL"]." 404");
				die;
			}
		}
		// Call the method & send arguments
		call_user_func_array([$this->controller, $this->method], $this->args);
	}
}
