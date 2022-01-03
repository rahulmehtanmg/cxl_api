<?php

namespace App\Http\appHelpers;

class AccessHelper {
	CONST CAN_VIEW = 'canView';
	CONST CAN_SAVE = 'canSave';
	CONST CAN_APPROVE = 'canApprove';

	/**
	 * Get all access types
	 * @param  int $process_id
	 * @return []             all aceess types
	 */
	public static function getAll($process_id) {
		return [
			self::CAN_VIEW => self::canView($process_id),
			self::CAN_SAVE => self::canSave($process_id),
			self::CAN_APPROVE => self::canApprove($process_id),
		];
	}

	/**
	 * Check view access
	 * @param  int $process_id
	 * @return boolean
	 */
	public static function canView($process_id) {
		return self::checkAccess($process_id, self::CAN_VIEW);
	}

	/**
	 * Check save access
	 * @param  int $process_id
	 * @return boolean
	 */
	public static function canSave($process_id) {
		return self::checkAccess($process_id, self::CAN_SAVE);
	}

	/**
	 * Check approve access
	 * @param  int $process_id
	 * @return boolean
	 */
	public static function canApprove($process_id) {
		return self::checkAccess($process_id, self::CAN_APPROVE);
	}

	/**
	 * Check access of a current user for a process_id
	 * @param  int $process_id
	 * @param  string $type
	 * @return boolean
	 */
	public static function checkAccess($process_id, $type) {
		$response = AppRequest::post(API_URL_AUTH_PROCESS_ACCESS, [
			'process' => $process_id,
		], ['Authorization' => request()->header('Authorization')]);

		$status = $response['status'];
		$result = false;

		if ($type == self::CAN_VIEW && $status == 200 && isset($response['data'][0]['view'])) {
			$result = $response['data'][0]['view'];
		} elseif ($type == self::CAN_SAVE && $status == 200 && isset($response['data'][0]['addEdit'])) {
			$result = $response['data'][0]['addEdit'];
		} elseif ($type == self::CAN_APPROVE && $status == 200 && isset($response['data'][0]['approve'])) {
			$result = $response['data'][0]['approve'];
		}
		return $result;
	}

}