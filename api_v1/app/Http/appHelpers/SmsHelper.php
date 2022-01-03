<?php

namespace App\Http\appHelpers;
use Illuminate\Support\Facades\Http;

class SmsHelper {

	/**
	 * Send SMS message on given mobile number
	 *
	 * Saurabh Suman saurabh.suman@kelltontech.com
	 * 11th November, 2020
	 *
	 * @return response from API
	 */
	public static function send($mobile_no, $message, $email = [], $smstype = null) {
		return AppRequest::post(API_URL_NOTIFICATION_SMS, [
			'mobile_no' => $mobile_no,
			'sms_type' => $smstype ?? 'otp',
			'body' => $message,
			'to_email' => $email['to'] ?? '',
			'email_body' => $email['email_body'] ?? '',
			'email_subject' => $email['email_subject'] ?? '',
		]);
	}

}