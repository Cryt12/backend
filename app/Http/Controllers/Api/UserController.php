<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(){
        
        return User::all();
    }

    //display resource
    public function show(string $id){
        return User::findOrFail($id);
    }

    //update user
    public function update(UserRequest $request, string $id)
    {
  
        $user = User::findOrFail($id);

        $validated = $request->validated();
        
        $user->name = $validated['name'];   

        $user-> save();
        
        return $user;
        
        }



    // update password user
        public function password(UserRequest $request, string $id)
    {
 
        $user = User::findOrFail($id);

        $validated = $request->validated();
        
        $user->password = hash::make($validated['password']);   

        $user-> save();
        
        return $user;
        
        }

    // update email user
    public function email(UserRequest $request, string $id)
    {
 
          
        $user = User::findOrFail($id);

        $validated = $request->validated();
        
        $user->email = $validated['email'];   

        $user-> save();
        
        return $user;


        }

    public function destroy(string $id){

        $user = User::find($id);

        $user->delete();

        return $user;
    }

    public function store(UserRequest $request){

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return $user;
    }
// update image
    public function image(UserRequest $request, string $id){

        $user = User::findOrFail($id);

        if (!is_null($user->image)){
            Storage::disk('public')->delete($user->image);
        }

        $validated = $request->validated();

        $user->image = $request->file('image')->storePublicly('image', 'public');

        $user ->save();

        return $user;
    }
}