<?php 

	function getDb() {
		return pg_connect("host=localhost port=5432 dbname=palettemaker user=palettemakeruser password=palettepalettepalette");
	}

	function removeParams($url, $paramsToRemove) {

		// Solution found here:
		// https://stackoverflow.com/questions/4937478/strip-off-url-parameter-with-php

		// Parse $url
		$parts = parse_url($url);

		// Sample output of $parts:
		// Array
		// (
		//     [scheme] => http
		//     [host] => localhost
		//     [port] => 8000
		//     [path] => /
		//     [query] => paletteName=Test4
		// )

		$params = [];
		parse_str($parts['query'], $params);

		// Foreach key in $paramArray,
		// remove key and its value from $url (which are stored right now in $params)
		foreach ($paramsToRemove as $removeMe) {
			unset($params[$removeMe]);
		}

		// Rebuild $url
		$newUrl = $parts['scheme'] . '://' . $parts['host'] . ':' . $parts['port'] . $parts['path'];

		// if $params still has stuff,
		// add ? to $newUrl
		// and join remaining params and add to $newUrl
		if (count($params) > 0) {
			$newUrl .= '?';
			$remainingParams = [];
			foreach ($params as $key => $value) {
				array_push($remainingParams, $key . '=' . urlencode($value)); 
 			}
			$newUrl .= join('&', $remainingParams);
		}

		// Return the new $url
		return $newUrl;

	}

	function assembleCurrentUrl() {

		$protocol = 'http';
		$host = $_SERVER['HTTP_HOST'];
		$request = $_SERVER['REQUEST_URI'];

		return $protocol . '://' . $host . $request;

	}

	function cleanUpErrorMessage($uglyError) {

		$niceError = "An error occurred. Try again?";

		// Key (name)=
		if (strpos($uglyError, 'Key (name)=')) {
			$niceError = "That name already exists. Try another?";
		}
		elseif (strpos($uglyError, 'Key (hex)=')) {
			$niceError = "That hex value is already used. Try another?";
		}

		return $niceError;

	}

?>