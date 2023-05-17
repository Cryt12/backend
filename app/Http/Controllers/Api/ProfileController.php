<?php

namespace App\Http\Controllers\Api;

use \App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


//Update image of the token bearer
class ProfileController extends Controller
{
    public function image(UserRequest $request)
    {

        $user = User::findOrFail($request->user()->id);

        if (!is_null($user->image)){
            Storage::disk('public')->delete($user->image);
        }

        $validated = $request->validated();

        $user->image = $request->file('image')->storePublicly('image', 'public');

        $user ->save();

        return $user;
    }
//display specified infomration of the token bearer
    public function show(Request $request){
        return $request->user();
    }

}
