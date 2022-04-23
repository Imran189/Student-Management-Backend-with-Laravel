<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordForgetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $token = Str::random(65);
        DB::table('password_resets')->insert([
            'email'=>$email,
            'token'=>$token,
            'created_at'=> now()->addHours(1)
        ]);

        $user = User::whereEmail($email)->first();

        //mail send

        // Mail::send('mail.password-reset',['token' => $token], function($msg) use ($email){
        //     $msg->to($email);
        //     $msg->subject('Password Reset Email');
        // });

        Notification::send($user, new PasswordForgetNotification($token));

        return response()->json([
            'message' => 'Password Reset Mail Send Success.Please Check Your Email'
        ]);
    }
}
