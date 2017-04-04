<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:32',
            'confirm_password' => 'required',
        ], [
            'old_password.required' => '旧密码不能为空',
            'new_password.required' => '新密码不能为空',
            'new_password.min' => '新密码至少要6位',
            'confirm_password.required' => '确认密码不能为空',
        ]);

        $user = auth()->user();

        if(! \Hash::check($request->get('old_password'), $user->password)) {
            return response()->json(['old_password' => '旧密码错误']);
        }

        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json(['status' => 'OK']);
    }
}
