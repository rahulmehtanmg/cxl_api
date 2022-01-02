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
			
            
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
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
			return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

	

}
