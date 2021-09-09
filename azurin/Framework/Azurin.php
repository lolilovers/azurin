<?php

// ---- Azurin Core ----

namespace Azurin\Framework;

use Azurin\Framework\Middleware;

// Version
if(! defined('AZURIN_VERSION'))
{
	define('AZURIN_VERSION', '2.2');
}

Class Azurin
{
	protected $controller   = DEFAULT_CONTROLLER;
	protected $method       = DEFAULT_METHOD;
	protected $args         = [];
	
	// Start listening
	public function listen()
	{	
		$filter		= new Middleware();
		$route		= $this->requestHandler();
		$before		= $filter->before($route);
		$after		= $this->responseHandler($before);
		$response	= $filter->after($after);

		return $response;
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
		
		// Get request URI
		$scheme	= isset($_SERVER['REQUEST_SCHEME']) ?: 'http';
		$scheme	= $scheme == 1 ? 'http' : $scheme;
		$uri	= $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$uri	= str_replace(rtrim(URL, '/'), '', $uri);
		$uri	= ltrim($uri, '/');
		
		// Parse request URI
		if (isset($uri)) {
			$request = $uri;
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
			if (file_exists(SRCPATH . 'Controllers/' . $request[0] . '.php')) {
				$this->controller = $request[0];
				unset($request[0]);
			} else {
				// controller not exist
				error_log('Controller or its method is not found: '. $request[0]);
				
				return send_404();
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
				
				return send_404();
			}
		}
		
		// Call the method & send arguments
		return call_user_func_array(
			[$this->controller, $this->method],
			$this->args
		);
	}
}