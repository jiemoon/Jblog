<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller{

    public function login(Request $request)
    {
        if($token = JWTAuth::getToken()){
            try{
                JWTAuth::invalidate($token);
            }catch(\Exception $e){
            }
        }
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['success' => false, 'msg' => '用户名或密码错误'], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'email' => $request->input('email'),
            'username' => auth()->user()->name
        ]);
    }

    public function signout(Request $request){
        if($token = JWTAuth::getToken()){
            try{
                JWTAuth::invalidate($token);
            }catch(\Exception $e){
            }
        }
        return response()->json(['success' => true]);
    }
}
