<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\Profile;
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
        // try {
       
        // $user=User::with('profile')->findOrFail(Auth::user()->id);
        // return new UserResource($user);
        //     if (! $user = JWTAuth::parseToken()->authenticate()) {
        //         return response()->json(['error' => 'User not found'], 404);
        //     }
        // } catch (JWTException $e) {
        //     return response()->json(['error' => 'Invalid token'], 400);
        // }
       
    //    $user=User::with('profile')->findOrFail(Auth::user()->id);
    //     return new UserResource($user);



       $user=User::with('role')->get();
        // return  UserResource::Collection($user);
        return  new UserCollection($user);
        
    }

    public function updateUser(UpdateUserRequest $request){
        if ($request->id !== Auth::id()) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à modifier cette profil.'
            ], 403);
        }
    
        $user = Auth::user();
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => $request->role_id
        ]);
    
        $profile = $user->profile;
    
       
        $profile->update([
            'bio' => $request->get('bio'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
        ]);
    
       
        $profile->skills()->sync($request->skills);
    
      
        $userData = $user->load(['profile.skills:id,name']); 
    
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $userData
        ], 200);
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}