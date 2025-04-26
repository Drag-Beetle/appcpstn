<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Attempt authentication
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Create a new token for the user
        $token = $request->user()->createToken("authToken")->plainTextToken;

        return response()->json([
            'message' => 'Login Successful',
            'access_token' => $token,
            'user' => $user,
        ]);

        

    }
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
            'phone' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'bio' => 'nullable|string',
        ]);

        // Assign the default role (tourist)
        $touristRole = Role::where('name', 'tourist')->first(); 
        if (!$touristRole) {
            return response()->json(['message' => 'Role not found'], 500);
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), 
            'role_id' => $touristRole->id, // Assign role_id dynamically
            'phone' => $validatedData['phone'] ?? null,
            'street' => $validatedData['street'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'country' => $validatedData['country'] ?? null,
            'postal_code' => $validatedData['postal_code'] ?? null,
            'bio' => $validatedData['bio'] ?? null,
            'is_active' => true, 
        ]);

        // Generate token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'access_token' => $token,
        ], 201);
    }

    public function sample(){
        return "Hello you are logged in!";
    }
}
