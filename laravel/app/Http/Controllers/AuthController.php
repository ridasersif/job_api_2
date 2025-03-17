<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json('user created sseccefaly');
        
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
    
    public function getAlluser(){
        $users=User::all();
        return response()->json($users);
    }
    public function show($id){
        $user=User::where('id',$id)->first();
        return response()->json($user);
    }
    public function updateUser(Request $request,$id){
       $user=User::find($id);
       $user->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password)
  
       ]);
       return response()->json('user updated sseccefaly');
    }
    public function deleteUser($id){
        $user=User::find($id);
        $user->delete();
        return response()->json('user deleted sseccefaly');
    }

}
