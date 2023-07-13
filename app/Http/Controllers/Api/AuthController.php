<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @bodyParam email string 
     * @bodyParam password string
     * @unauthenticated
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $credentials = request(['email', 'password']);
            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @bodyParam name string 
     * @bodyParam email string 
     * @bodyParam password string
     * @unauthenticated
     */

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }



    /**
     * @header Authorization Bearer {token} 
     */

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }



    /**
     * @header Authorization Bearer {token} 
     */

    public function getUsers()
    {
        try {
            $users = User::where('id', '!=', auth()->user()->id)->get();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
