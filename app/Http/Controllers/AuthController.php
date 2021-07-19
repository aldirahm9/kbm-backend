<?php

namespace App\Http\Controllers;

use App\ApiUtils\SiakadUtils;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $siakadutils;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $resp = json_decode(SiakadUtils::login($username,$password));
        if ($resp == null || $resp->status == false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if(User::where('username', $username)->first() ==null) {
            User::create([
                'username' => $username,
                'password' => bcrypt($password),
                'token_siakad' =>$resp->Authorization,
                'nama' => $resp->nama,
            ]);
        }


        $token = auth()->attempt(['username'=>$username,'password' =>$password]);
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
