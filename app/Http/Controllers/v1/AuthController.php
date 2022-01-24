<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller\v1;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private function isValid($key,$value)
    {
        $user = User::all($key)->where($key,'=',$value);
        if ($user->isEmpty())
        {
            return false;
        }
        return true;
    }

    public function auth(LoginRequest $request)
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['login'],
            'password' => $input['password'],
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => 'JWT',
            'user' => [
                'login' => auth()->user()->email,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL()
            ]
        ]);
    }

    public function sso(Request $request)
    {
        return response('',501);
    }

    public function store(Request $request)
    {
        try
        {
            if($this->isValid('email',$request->input('email')))
            {
                return response()->json(['error' => 'E-mail is already in use'],400);
            }

            if($this->isValid('cnpj',$request->input('cnpj')))
            {
                return response()->json(['error' => 'CNPJ is already in use'],400);
            }

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->cnpj = $request->input('cnpj');
            $user->company_name = $request->input('company_name');
            $user->phone_number = $request->input('phone_number');
            if($user->save())
            {
                return response()->json(['user_id' => $user->id],201);
            }
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function show($id)
    {
        $user = User::all('id','name','email','cnpj','company_name','phone_number')->where('id','=',$id);
        if ($user->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($user->first());
    }

    public function update(Request $request, $id)
    {
        try
        {
            $user = User::find($id);
            if (is_null($user))
            {
                return response()->json(['error' => 'Not found'],404);
            }

            if( ($user->email != $request->input('email')) && ($this->isValid('email',$request->input('email'))) )
            {
                return response()->json(['error' => 'E-mail is already in use'],400);
            }

            if( ($user->cnpj != $request->input('cnpj')) && ($this->isValid('cnpj',$request->input('cnpj'))) )
            {
                return response()->json(['error' => 'CNPJ is already in use'],400);
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->cnpj = $request->input('cnpj');
            $user->company_name = $request->input('company_name');
            $user->phone_number = $request->input('phone_number');
            if($user->save())
            {
                return response('',200);
            }
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

}
