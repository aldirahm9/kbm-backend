<?php

namespace App\Http\Controllers;

use App\ApiUtils\SiakadUtils;
use App\ProgramStudi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        // NOTE: commented to backdoor test Dosen account
        // $resp = SiakadUtils::login($username,$password);
        // $resp_json = json_decode($resp);

        // if($resp->status() == 500) {
        //     return response()->json(['error' => 'Internal Server Error'], 500);
        // }
        // else if ($resp_json == null || $resp_json->status == false) {

        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        if($request->remember) $ttl = 43800; // kalau remember me, ttl jadi sebulan
        else $ttl = auth()->factory()->getTTL();
        if(User::where('username', $username)->first() ==null) {
            if($resp_json->mode == 9) {
                if(substr($username,0,4) == '3145' || substr($username,0,5) == '13136') $kode_prodi = 13136; //ilkom
                else if(substr($username,0,4) == '3125' || substr($username,0,5) == '13056') $kode_prodi = 13056; //mtk
                else if(substr($username,0,4) == '3115' || substr($username,0,5) == '13016') $kode_prodi = 13016; //penmat
                else if(substr($username,0,4) == '3136' || substr($username,0,5) == '13098') $kode_prodi = 13016; //s2 penmat
                else if(substr($username,0,5) == '13146') $kode_prodi = 13146; //statis
                $prodi = ProgramStudi::where('kode',$kode_prodi)->first();
                $u = User::create([
                    'username' => $username,
                    'password' => bcrypt($password),
                    'token_siakad' =>$resp_json->Authorization,
                    'nama' => $resp_json->nama,
                    'role' => 1,
                    'prodi_id' => $prodi->id
                ]);
                $token = auth()->setTTL($ttl)->attempt(['username'=>$username,'password' =>$password]);

            }
            else if($resp_json->mode == 8) {
                $u = User::create([
                    'username' => $username,
                    'password' => bcrypt($password),
                    'token_siakad' =>$resp_json->Authorization,
                    'nama' => $resp_json->nama,
                    'role' => 2,
                ]);
                $token = auth()->setTTL($ttl)->attempt(['username'=>$username,'password' =>$password]);
                $info_dosen = SiakadUtils::getInfoDosen($username,$token);
                $prodi = ProgramStudi::where('kode',$info_dosen->prodi)->first();
                $u->prodi_id = $prodi->id;
                $u->save();
            }
        } else {
            $token = auth()->setTTL($ttl)->attempt(['username'=>$username,'password' =>$password]);
            if(!$token) return response()->json(['message' => 'Username atau password tidak sesuai!'],401);
        }


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
            'expires_in' => auth()->factory()->getTTL() . ' minutes'
        ]);
    }
}
