<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller {
	
	/**
	 * @OA\Post(
	 *     path="/auth/v1/register",
	 *     tags={"Authentication"},
	 *     description="Register User",
	 *     summary="Register With New User",
	 *     operationId="register",
	 *     @OA\Parameter(
	 *         description="Emailid",
	 *         name="email",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string",
	 *         ),
	 *     ),
	 *     @OA\Parameter(
	 *         description="Password",
	 *         name="password",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string",
	 *         ),
	 *     ),
	 *     @OA\Parameter(
	 *         description="UserName",
	 *         name="user_name",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string",
	 *         ),
	 *     ),
	 *     @OA\Parameter(
	 *         description="OrganizationId",
	 *         name="org_id",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="integer",
	 *         ),
	 *     ),
	 *     @OA\Parameter(
	 *         description="Mobile",
	 *         name="mobile",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string",
	 *         ),
	 *     ),
	 
	 *     @OA\Response(
	 *         response="200",
	 *         description="Successfully registered"     *
	 *     ),
	 *     @OA\Response(
	 *         response="401",
	 *         description="Unauthorized"
	 *     )
	 * )
	 */
	
	public function register(Request $request)
    {
        //validate incoming request 
        try {

            $user = new User;
			$user->org_id = $request->input('org_id');
			$user->user_name = $request->input('user_name');
            $user->mobile_num = $request->input('mobile');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            if($user->save()){
				$response = $this->apiSuccess(__('mpin.OTP_verified'));
			}
			else{
				$response = $this->apiError(UNAUTHORISED, array(__(GLOBAL_REASON) => __('login.register_success')));	
			}

			return $response;

        } catch (\Exception $e) {
            //return error message
			return $this->apiError(API_ERROR, $e->getmessage());
        }

    }

	/**
	 * --------------------------------
	 *  Basic configuration for swagger
	 * --------------------------------
	 * @OA\Info(title="Authorization", version="3.0.0")
	 */

	/**
	 * ------------------------------
	 * JWT Authentication for swagger
	 * ------------------------------
	 *
	 * @OA\SecurityScheme(
	 *   securityScheme="JWTHeaderAuthentication",
	 *   type="apiKey",
	 *   in="header",
	 *   name="Authorization"
	 * )
	 */

	/**
	 * @OA\Post(
	 *     path="/auth/v1/login",
	 *     tags={"Authentication"},
	 *     description="Login User",
	 *     summary="Login With User Credentials",
	 *     operationId="login",
	 *     @OA\Parameter(
	 *         description="Email",
	 *         name="email",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string",
	 *         ),
	 *     ),
	 *     @OA\Parameter(
	 *         description="Password",
	 *         name="password",
	 *         in="query",
	 *         required=true,
	 *         @OA\Schema(
	 *             type="string",
	 *         ),
	 *     ),
	 
	 *     @OA\Response(
	 *         response="200",
	 *         description="Successfully lognin"     *
	 *     ),
	 *     @OA\Response(
	 *         response="401",
	 *         description="Unauthorized"
	 *     )
	 * )
	 */
	 public function login(Request $request)
    {
		$this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
			$response = $this->apiError(UNAUTHORISED, array(__(GLOBAL_REASON) => __('login.invalid')));
        }
		else{
		$user = Auth::user();
		$response = $this->respondWithToken($token,$user);
		}
        return $response;
    }


	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */

	protected function respondWithToken($token, $user) {
		$data = array();
		$data['access_token'] = $token;
		$data['token_type'] = 'bearer';
		$data['expires_in'] = Auth::factory()->getTTL() * 60;
		$data['id'] = $user['id']?? '';
		return $this->apiSuccess(__('login.token'), $data);
	}

	

}
