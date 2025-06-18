<?php

function basePath($path = ''){
	$cur_path = dirname($_SERVER['SCRIPT_NAME']);
	return rtrim($cur_path, '/') . $path;
}

function getRequestPath(){
	$scriptName = dirname($_SERVER['SCRIPT_NAME']);
	$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	return '/' . ltrim(str_replace($scriptName, '', $requestUri), '/');
}