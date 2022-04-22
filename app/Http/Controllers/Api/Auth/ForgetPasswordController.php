<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class ForgetPasswordController extends Controller
{
    public function forgot(Request $request){
        $validate= validator::make($request->all(),[
            'email'=>'required|email|exists:users',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ],422);
        }

        $email = $request->email;
        $token = Str::random(6);
        DB::table('password_resets')->insert([
            'email'=>$email,
            'token'=>$token,
            'created_at'=> now()->addHours(1)
        ]);

        //mail send

    }
}
