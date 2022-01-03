<?php

namespace App\Http\appHelpers;

class ResponseHelper {
	/**
	 * Return json error response
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return JSON Response
	 */
	public static function error($code, $otherData = []) {
		switch ($code) {

		case 'BAD_REQUEST':
			$statusCode = 400;
			$message = 'Bad request';
			break;

		case 'INVALID_TOKEN':
			$statusCode = 401;
			$message = 'Invalid token';
			break;

		case 'UNAUTHORISED':
			$statusCode = 401;
			$message = 'Unauthorised';
			break;

		case 'VALIDATION_ERROR':
			$statusCode = 422;
			$message = 'Validation error';
			break;

		case 'API_ERROR':
			$statusCode = 500;
			$message = 'Api error';
			break;

		default:
			$statusCode = 401;
			$message = $code;
			break;
		}

		return response()->json(array_merge([
			'status' => $statusCode,
			'message' => $message,
		], ['data' => $otherData]), $statusCode);
	}

	/**
	 * Return json success response
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return JSON Response
	 */
	public static function success($message, $otherData = []) {
		if (env('ENCRYPT_ID_TYPE', 'NONE') != 'NONE') {
			$otherData = json_decode(json_encode($otherData), true);
			$otherData = self::encryptIDs($otherData);
		}

		return response()->json(array_merge([
			'status' => 200,
			'message' => $message,
		], ['data' => $otherData]), 200);
	}

	/**
	 * Throw json error
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return \App\Exceptions\GenericException
	 */
	public static function throwError($message) {
		throw new \App\Exceptions\GenericException($message);
	}

	/**
	 * Encrypt all id keys send
	 * set ENCRYPT_ID_TYPE=COMPLEX/SIMPLE/NONE in .env
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return JSON Response
	 */
	public static function encryptIDs($dataArray) {
		if (is_array($dataArray)) {
			foreach ($dataArray as $key => &$value) {

				if (is_array($value)) {
					$value = self::encryptIDs($value);
				} else {
					if ($key == 'id' || substr($key, -3) == '_id') {
						$value = CryptHelper::encryptIDValue($value);
					}
				}
			}
		}

		return $dataArray;
	}

	/**
	 * Decrypt all id keys send
	 * set ENCRYPT_ID_TYPE=COMPLEX/SIMPLE/NONE in .env
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return JSON Response
	 */
	public static function decryptIDs($dataArray) {
		if (is_array($dataArray)) {
			foreach ($dataArray as $key => &$value) {

				if (is_array($value)) {
					$value = self::decryptIDs($value);
				} else {
					if ($key == 'id' || substr($key, -3) == '_id') {
						$value = CryptHelper::decryptIDValue($value);
					}
				}
			}
		}

		return $dataArray;
	}

}