<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use \App\Http\appHelpers\ResponseHelper;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    
    /**
	 * Return API error
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return response
	 */
	public function apiError($message, $data = []) {
		return ResponseHelper::error($message, $data);
	}

	/**
	 * Return API success
	 *
	 * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return response
	 */
	public function apiSuccess($message, $data = []) {
		return ResponseHelper::success($message, $data);
	}

	/**
	 * Return request validation error
	 *
    * Rahul Mehta <rahul.mehta@cxl.io>
	 * Created on 2022-01-02
	 *
	 * @return response
	 */
	public function validateRequest($request, $rules, $message = null) {
		$this->validationMessage = $message;
		$this->validate($request, $rules);
	}
}
