<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class AuthController extends Controller
{
    //Registration User
    public function register(Request $request, User $user)
    {
        //Validation
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
        ]);

        //Create User to DB
        $user = $user->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'api_token' => bcrypt($request->email)
        ]);
        
        //Response
        $response = fractal()
                ->item($user)
                ->transformWith(new UserTransformer)
                ->addMeta([
                    'token' => $user->api_token
                ])
                ->toArray();
        
        return response()->json($response, 201);
    }

    //Login User
    public function login(Request $request, User $user)
    {
        //Checking if you're not yet login
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return response()->json(["error" => "Your credential is wrong!"], 401);
        }

        $user = $user->find(Auth::user()->id);

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => $user->api_token
            ])
            ->toArray();
    }
}
