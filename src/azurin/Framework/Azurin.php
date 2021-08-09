<?php

/**
 * ===========================
 * Azurin Framework Core
 * ===========================
 */

namespace Azurin\Framework;

// Version
if(! defined('AZURIN_VERSION'))
{
	define('AZURIN_VERSION', '2.2');
}

Class Azurin
{
	protected $controller	= DEFAULT_CONTROLLER;
	protected $method		= DEFAULT_METHOD;
	protected $args			= [];	
	
	// Entry point
	public function listen()
	{
		/**
		 * ---- Request Handler ----
		 * process client request 
		 * and parse to array
		 * 
		 * @return array
		 */
		$route = $this->requestHandler();

		/**
		 * ---- Route ----
		 * Before the route is sent to response, you can
		 * easily create a custom filter or custom
		 * route definition here
		 * 
		 * route:
		 * $route[0] is controller
		 * $route[1] is method
		 * 
		 * example:
		 * $route = new MyFilter()->myMiddleware($route);
		 * $route = new MyRouter($route)->getRoute();
		 * 
		 * ---- Response Handler ----
		 * call controller & method based on route
		 * 
		 * @param array
		 */
		return $this->responseHandler($route);
	}
	
	// Request handler
	public function requestHandler()
	{
		// HTTPS Force
		if (HTTPS_FORCE) {
			if (empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
				header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
				
				exit();
			}
		}
		
		// Magic router
		if (isset($_GET['uri'])) {
			$request = $_GET['uri'];
			$request = filter_var($request, FILTER_SANITIZE_URL);
			$request = explode('/', $request);
			
			return $request;
		}
	}
	
	// Response handler
	public function responseHandler($request)
	{
		// Check controller
		if (! empty($request[0])) {
			// controller exist
			if (file_exists(SRCPATH.'Controllers/' . $request[0] . '.php')) {
				$this->controller = $request[0];
				unset($request[0]);
			} else {
				// controller not exist
				error_log('Controller or its method is not found: '. $request[0]);
				require_once SRCPATH.'Views/errors/notfound.html';
				
				return header($_SERVER["SERVER_PROTOCOL"] . " 404");
				die;
			}
		}
		
		// Initialize & run controller
		$this->controller = 'Azurin\Controllers\\' . $this->controller;
		$this->controller = new $this->controller;
		
		// Check method
		if (! empty($request[1])) {
			// method exist
			if (method_exists($this->controller, $request[1])) {
				$this->method = $request[1];
				unset($request[1]);
				// Initialize arguments
				if (! empty($request)) {
					$this->args = array_values($request);
				}
			} else {
				// method not exist
				error_log('Controller method is not found: '. $request[1]);
				require_once SRCPATH.'Views/errors/notfound.html';
				
				return header($_SERVER["SERVER_PROTOCOL"] . " 404");
				die;
			}
		}
		
		// Call the method & send arguments
		return call_user_func_array(
			[$this->controller, $this->method],
			$this->args
		);
	}
}