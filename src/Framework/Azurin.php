<?php

/**
 * ===========================
 * Azurin Micro Framework Core
 * ===========================
 */

namespace Framework;

// Version
if(! defined('AZURIN_VERSION'))
{
	define('AZURIN_VERSION', '2.1');
}

Class Azurin
{
	protected $controller	= DEFAULT_CONTROLLER;
	protected $method		= DEFAULT_METHOD;
	protected $args			= [];	
	
	// Entry point
	public function listen()
	{
		// Logger
		$this->logger();
		// Request
		$route = $this->requestInterface();
		// Response
		$this->responseInterface($route);
	}
	
	// Logger
	public function logger()
	{
		error_reporting(E_ALL); 
		ini_set('ignore_repeated_errors', TRUE); 
		ini_set('display_errors', ERR_DISPLAY); 
		ini_set('log_errors', TRUE); 
		ini_set('error_log', SRCPATH.'Storage/log/errors.log');	
	}
	
	// Request handler
	public function requestInterface()
	{
		// HTTPS Force
		if(HTTPS_FORCE)
		{
			if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
				header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
				exit();
			}
		}
		
		// Magic router
		if(isset($_GET['uri']))
		{
			$request = $_GET['uri'];
			$request = filter_var($request, FILTER_SANITIZE_URL);
			$request = explode('/', $request);
			return $request;
		}
	}
	
	// Response handler
	public function responseInterface($request)
	{
		// Check controller
		if(! empty($request[0])) {
			// controller exist
			if(file_exists(SRCPATH.'Controllers/'.$request[0].'.php')) {
				$this->controller = $request[0];
				unset($request[0]);
			}
			// controller not exist
			else {
				error_log('Controller or its method is not found: '.$request[0]);
				require_once SRCPATH.'Views/errors/notfound.html';
				return header($_SERVER["SERVER_PROTOCOL"]." 404");
				die;
			}
		}
		
		// Initialize & run controller
		$this->controller = 'Controllers\\'.$this->controller;
		$this->controller = new $this->controller;
		
		// Check method
		if(! empty($request[1])) {
			// method exist
			if(method_exists($this->controller, $request[1])) {
				$this->method = $request[1];
				unset($request[1]);
				// Initialize arguments
				if(! empty($request)) {
					$this->args = array_values($request);
				}
			}
			// method not exist
			else {
				error_log('Controller method is not found: '.$request[1]);
				require_once SRCPATH.'Views/errors/notfound.html';
				return header($_SERVER["SERVER_PROTOCOL"]." 404");
				die;
			}
		}
		
		// Call the method & send arguments
		call_user_func_array([$this->controller, $this->method], $this->args);
	}
}
