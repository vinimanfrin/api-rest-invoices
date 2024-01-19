<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    use HttpResponses;
    public function login(Request $request)
    {
        if (Auth::attempt($request->only("email","password"))){
            return $this->response("ok",200,[
                'token' => $request->user()->createToken('invoice')->plainTextToken
            ]);
        }
        return $this->response("Not Authorized",403);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response('Token Revoked',200);
    }
}
