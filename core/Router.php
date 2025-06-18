<?php

class Router {
	private $routes = [];

	public function get($path, $callback){
		$this->routes['GET'][$path] = $callback;
	}

	public function post($path, $callback){
		$this->routes['POST'][$path] = $callback;
	}

	public function resolve($method, $path){
		if(isset($this->routes[$method][$path])){
			return call_user_func($this->routes[$method][$path]);
		}

		http_response_code(404);
		echo "404 Not Found";
	}
}