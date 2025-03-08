<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $updateProfile =['name','email','phone','password'];

    public function profile(Request $request){
        $user = $request->user();
        $data =[
            'user' => $user
        ];
        return response()->json($data);
    }

    public function update(Request $request){
        $user = $request->user();
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->update($request->only($this->updateProfile));
        $data =[
            'messsage'=>'Profile updated successfully',
            'user' => $user
        ];
        return response()->json($data);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();
        $data =[
            'message' => 'User successfully logged out'
        ];
        return response()->json($data);
    }

    public function deleteAccount(Request $request){
        $user = $request->user();
        $user->delete();
        $data =[
            'message' => 'User deleted successfully'
        ];
        return response()->json($data);
    }

}
