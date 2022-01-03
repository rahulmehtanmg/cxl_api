<?php

namespace App\Http\appHelpers;

class CryptHelper {
	CONST ENCRYPT_ID_TYPE = 'ENCRYPT_ID_TYPE';
	/**
	 * Encrypt Value
	 *
	 * Saurabh Suman saurabh.suman@kelltontech.com
	 * 3rd June 2020
	 *
	 * @return encrypted value
	 */
	public static function encrypt($value) {
		return encrypt($value);
	}

	/**
	 * Decrypt Value
	 *
	 * Saurabh Suman saurabh.suman@kelltontech.com
	 * 3rd June 2020
	 *
	 * @return decrypted value
	 */
	public static function decrypt($value) {
		return decrypt($value);
	}

	/**
	 * Encrypt ID Value
	 *
	 * set ENCRYPT_ID_TYPE=COMPLEX/SIMPLE/NONE in .env
	 *
	 * Saurabh Suman <saurabh.suman@kelltontech.com>
	 * Created on 2020-05-30
	 *
	 * @return encrypted value
	 */
	public static function encryptIDValue($value) {
		if (env(self::ENCRYPT_ID_TYPE, 'NONE') == 'NONE') {
			return $value;
		} elseif (env(self::ENCRYPT_ID_TYPE, 'NONE') == 'SIMPLE') {
			return 'ens-' . $value;
		} elseif (env(self::ENCRYPT_ID_TYPE, 'NONE') == 'COMPLEX') {
			return 'enc-' . self::encrypt($value);
		}

	}

	/**
	 * Decrypt data
	 *
	 * Saurabh Suman <saurabh.suman@kelltontech.com>
	 * Created on 2020-05-30
	 *
	 * @return decrypted plain value
	 */
	public static function decryptIDValue($value, $forceDecrypt = true) {
		if (substr($value, 0, 4) == 'enc-') {
			return self::decrypt(substr($value, 4));
		} elseif (substr($value, 0, 4) == 'ens-') {
			return substr($value, 4);
		}

		if ($forceDecrypt && env(self::ENCRYPT_ID_TYPE, 'NONE') != 'NONE') {
			throw new \App\Exceptions\GenericException(__('Invalid encrypted value'));
		}
	}
}