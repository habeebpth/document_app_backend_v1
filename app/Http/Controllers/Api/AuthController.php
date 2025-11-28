<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'user_name' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::where('user_name', $request->user_name)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid username or password'
                ], 401);
            }

            $token = $user->createToken('API TOKEN')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user'  => $user
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error"  => $e->getMessage(),
            ], 500);

        }
    }

    public function register(Request $request)
{
    $request->validate([
        'name'             => 'required|string|max:255',
        'mobile_number'    => 'required|digits:10',
        'whatsapp_number'  => 'nullable|digits:10',
        'user_name'        => 'required|string|unique:users,user_name',
        'password'         => 'required|string|min:4',
    ]);

    // Create User
    $user = User::create([
        'name'             => $request->name,
        'mobile_number'    => $request->mobile_number,
        'whatsapp_number'  => $request->whatsapp_number,
        'user_name'        => $request->user_name,
        'password'         => Hash::make($request->password),
    ]);

    // Generate Token
    $token = $user->createToken('API TOKEN')->plainTextToken;

    return response()->json([
        'status'  => true,
        'message' => 'User registered successfully',
        'token'   => $token,
        'user'    => $user,
    ], 201);
}

}
