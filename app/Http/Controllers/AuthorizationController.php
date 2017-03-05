<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Illuminate\Validation\ValidationException;
use App\User;

class AuthorizationController extends Controller
{
    public function getToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password))
        {
            return $user;
        }



        return 'err';
    }

    public function renewToken(Request $request)
    {

    }

    public function unsetToken(Request $request)
    {

    }
}