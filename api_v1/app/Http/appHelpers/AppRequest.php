<?php

namespace App\Http\appHelpers;
use Illuminate\Support\Facades\Cache;

class AppRequest
{
	/**
	 * Replace URL tokens
	 * @param  string $url 
	 * @return string      url with tokens replaced
	 */
	public static function replaceUrlTokens($url)
	{
		$possibleTokens = [
			'API_COREHR',
			'API_ER',
			'API_CBS',
			'API_ESS',
			'API_LTA',
			'API_NOTI',
			'API_PAY',
			'API_AUTH',
		];

		foreach ($possibleTokens as $token) {
			$url = str_replace(['{{'.$token.'}}', $token], env($token), $url);
		}
		return $url;
	}

	/**
	 * Get the formatted headers to send api request
	 * @param  array  $otherHeaders 
	 * @return []               complete header array
	 */
	public static function getHeaders($otherHeaders = [])
	{
		return array_merge([
			'Authorization' => request()->header('Authorization')
		], $otherHeaders);
	}

	/**
	 * Parse the response in JSON format
	 * @param   $response 
	 * @return JSON/null           
	 */
	protected static function parseResponse($response)
	{
		return (!empty($response)) ? $response->json() : null;
	}

	/**
	 * Make GET request
	 * @param  string $url     URL of API
	 * @param  array  $headers 
	 * @return JSON response          
	 */
	public static function get($url,$data = [],$headers = [])
	{
		$headers = self::getHeaders($headers);
		$url = self::replaceUrlTokens($url). '?'. http_build_query($data);
		$response = Request::get($url, $headers);
		return self::parseResponse($response);
	}

	/**
	 * Make POST request
	 * @param  string $url     URL of API
	 * @param  array  $data    POST paramters 
	 * @param  array  $headers 
	 * @return JSON response          
	 */
	public static function post($url, $data, $headers = [])
	{
		$headers = self::getHeaders($headers);
		$url = self::replaceUrlTokens($url);
		$response = Request::post($url, $data, $headers);
		return self::parseResponse($response);
	}

	/**
	 * Make PUT request
	 * @param  string $url     URL of API
	 * @param  array  $data    PUT parameters 
	 * @param  array  $headers 
	 * @return JSON response          
	 */
	public static function put($url, $data, $headers = [])
	{
		$headers = self::getHeaders($headers);
		$url = self::replaceUrlTokens($url);
		$response = Request::put($url, $data, $headers);
		return self::parseResponse($response);
	}

	/**
	 * Make DELETE request
	 * @param  string $url     URL of API
	 * @param  array  $headers 
	 * @return JSON response          
	 */
	public static function delete($url, $headers = [])
	{
		$headers = self::getHeaders($headers);
		$url = self::replaceUrlTokens($url);
		$response = Request::delete($url, $headers);
		return self::parseResponse($response);
	}

}
