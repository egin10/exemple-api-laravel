<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use Auth;

class UserController extends Controller
{
    //show all users
    public function users(User $user)
    {
        $users = $user->all();

        // return response()->json($users);
        return fractal()
                ->collection($users)
                ->transformWith(new UserTransformer)
                ->toArray();
    }

    //show profile's user
    public function profile(User $user)
    {
        $user = $user->find(Auth::user()->id);

        return fractal()
                ->item($user)
                ->transformWith(new UserTransformer)
                ->includePosts()
                ->toArray();
    }

    //show profile's user by Id
    public function profileById(User $user, $id)
    {
        $user = $user->find($id);

        return fractal()
                ->item($user)
                ->transformWith(new UserTransformer)
                ->includePosts()
                ->toArray();
    }

}
