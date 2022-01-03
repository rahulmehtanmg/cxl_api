<?php

namespace App\Http\appHelpers;

use Illuminate\Support\Facades\Http;

class Request {
	CONST GET = 'GET';
	CONST POST = 'POST';
	CONST PUT = 'PUT';
	CONST DELETE = 'DELETE';

	public static $baseUrl = '';
	/**
	 * Perform GET request
	 * @param  string $url
	 * @param  array  $header
	 * @return response object
	 */
	public static function get($url, $header = []) {
		return self::makeRequest(self::GET, $url, [], $header);
	}

	/**
	 * Perform POST request
	 * @param  string $url
	 * @param  array  $data
	 * @param  array  $header
	 * @return response object
	 */
	public static function post($url, $data = [], $header = []) {
		return self::makeRequest(self::POST, $url, $data, $header);
	}

	/**
	 * Perform PUT request
	 * @param  string $url
	 * @param  array  $data
	 * @param  array  $header
	 * @return response object
	 */
	public static function put($url, $data = [], $header = []) {
		return self::makeRequest(self::PUT, $url, $data, $header);
	}

	/**
	 * Perform DELETE request
	 * @param  string $url
	 * @param  array  $header
	 * @return response object
	 */
	public static function delete($url, $header = []) {
		return self::makeRequest(self::DELETE, $url, [], $header);
	}

	/**
	 * Make request
	 * @param  string $type   GET, POST, PUT, DELETE
	 * @param  string $url
	 * @param  array  $data
	 * @param  array  $header
	 * @return response object
	 */
	protected static function makeRequest($type, $url, $data = [], $header = []) {

		$response = null;

		if (empty($header)) {

			switch ($type) {

			case self::GET:
				$response = Http::get($url);
				break;

			case self::POST:
				$response = Http::post($url, $data);
				break;

			case self::PUT:
				$response = Http::put($url, $data);
				break;

			case self::DELETE:
				$response = Http::delete($url);
				break;

            }

		} else {
			switch ($type) {

			case self::GET:
				$response = Http::withHeaders($header)->get($url);
				break;

			case self::POST:
				$response = Http::withHeaders($header)->post($url, $data);
				break;

			case self::PUT:
				$response = Http::withHeaders($header)->put($url, $data);
				break;

			case self::DELETE:
				$response = Http::withHeaders($header)->delete($url);
				break;
			}

		}

		return $response;
	}

}
