<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
   
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' =>$request->role_id
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'), 201);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                return response()->json(['error' => 'L\'adresse e-mail n\'existe pas'], 404);  
            }
    
           
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Mot de passe incorrect'], 401);  
            }
    
            
            return $this->respondWithToken($token);
    
        } catch (\Exception $e) {
          
            return response()->json(['error' => 'Une erreur inattendue s\'est produite, veuillez réessayer plus tard'], 500);
        }
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60  
        ]);
    }
    
   
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    public function updateUser(UpdateUserRequest $request){
        $user = Auth::user();
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' =>$request->role_id
        ]);


        return response()->json(['message' => 'profile updated Successfully'], 201);
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}