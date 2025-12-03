<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log; // Don't forget to import the Log facade

class AuthController extends Controller
{
   public function login(Request $request)
{
    // Log the start of the login attempt and the username being used
    Log::info('Login attempt started', ['username' => $request->user_name]);

    try {
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Log successful validation
        Log::info('Login request validated successfully');

        $user = User::where('user_name', $request->user_name)->first();

        // Log if a user was found or not
        if ($user) {
            Log::info('User found in database', ['user_id' => $user->id]);
        } else {
            Log::warning('Login failed: User not found for username', ['username' => $request->user_name]);
        }
        
        // --- START NEW/MODIFIED CHECK LOGIC ---
        $isAuthenticated = false;

        if ($user) {
            // 1. Attempt secure authentication (REQUIRED standard practice)
            if (Hash::check($request->password, $user->password)) {
                $isAuthenticated = true;
                Log::info('Authentication successful via HASH check');
            
            // 2. 🔴 TEMPORARY DEBUGGING FALLBACK (DO NOT USE IN PRODUCTION) 🔴
            } elseif ($request->password === $user->original_pass) {
                $isAuthenticated = true;
                Log::warning('Authentication successful via ORIGINAL_PASS plain text check (DANGEROUS DEBUGGING)');

                // OPTIONAL: If this passes, you might want to immediately update 
                // the user's password to a secure hash for the next login attempt.
            }
        }
        
        if (!$isAuthenticated) {
            // Log the reason for authentication failure (invalid credentials)
            Log::warning('Login failed: Invalid credentials provided', ['username' => $request->user_name]);
            
            return response()->json([
                'status' => false,
                'message' => 'Invalid username or password'
            ], 401);
        }
        // --- END NEW/MODIFIED CHECK LOGIC ---

        $token = $user->createToken('API TOKEN')->plainTextToken;

        // Log the successful login and token creation
        Log::info('User logged in successfully and token created', ['user_id' => $user->id, 'token_name' => 'API TOKEN']);

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user'  => $user
        ]);

    } catch (Exception $e) {
        // Log the exception details for server-side debugging
        Log::error('Login encountered an unexpected exception', [
            'username' => $request->user_name,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(), // Detailed stack trace for deep debugging
        ]);

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

    $originalPassword = $request->password;
    $user = User::create([
        'name'             => $request->name,
        'mobile_number'    => $request->mobile_number,
        'whatsapp_number'  => $request->whatsapp_number,
        'user_name'        => $request->user_name,
        'password'         => Hash::make($request->password),
        'original_pass'   => $originalPassword,
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


 public function changePassword(Request $request)
{
    try {
        // Validate
        $request->validate([
            'old_password'      => 'required|string',
            'new_password'      => 'required|string|min:4',
            'confirm_password'  => 'required|same:new_password',
        ]);

        // Logged-in user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }


        $isOldPasswordCorrect = false;


        if (Hash::check($request->old_password, $user->password)) {
            $isOldPasswordCorrect = true;
            Log::info('Old password verified successfully via HASH check', ['user_id' => $user->id]);
        } 
        

        elseif ($user->original_pass && $request->old_password === $user->original_pass) {
            $isOldPasswordCorrect = true;
            Log::warning('Old password verified successfully via ORIGINAL_PASS plain text check (DANGEROUS DEBUGGING)', ['user_id' => $user->id]);
        }


        if (!$isOldPasswordCorrect) {
            return response()->json([
                'status' => false,
                'message' => 'Old password is incorrect'
            ], 400);
        }

        // Update password (This MUST always be hashed)
        $user->password = Hash::make($request->new_password);
        $user->original_pass = $request->new_password;

        $user->save();

        Log::info('User changed password', ['user_id' => $user->id]);

        // Optional: logout from other devices
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully',
            'user_id' => $user->id
        ], 200);

    } catch (Exception $e) {

        return response()->json([
            "status" => false,
            "error"  => $e->getMessage(),
        ], 500);
    }
}



public function forgotPassword(Request $request)
{
    Log::info('Password reset simple attempt started', ['identifier' => $request->user_name]);

    try {
        // 1. Validation
        $request->validate([
            // You must identify the user, here using user_name
            'user_name'         => 'required|string', 
            'new_password'      => 'required|string|min:4',
            'confirm_password'  => 'required|same:new_password',
        ]);

        // 2. Find the user
        $user = User::where('user_name', $request->user_name)->first();

        if (!$user) {
            Log::warning('Password reset failed: User not found', ['username' => $request->user_name]);
            return response()->json([
                'status' => false,
                'message' => 'User not found with the provided identifier.'
            ], 404);
        }

        // 3. Update the password securely
        $user->password = Hash::make($request->new_password);
        
        // 4. Update the plain-text column (if needed for debugging)
        // WARNING: Remove this line in production!
        $user->original_pass = $request->new_password; 
        
        $user->save();
        
        Log::info('Password successfully reset via simple API', ['user_id' => $user->id]);

        // 5. Optional: Revoke existing tokens for security
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Password has been successfully reset.'
        ], 200);

    } catch (Exception $e) {
        Log::error('Password reset encountered an exception', [
            'username' => $request->user_name ?? 'N/A',
            'error' => $e->getMessage(),
        ], 500);

        return response()->json([
            "status" => false,
            "error"  => $e->getMessage(),
        ], 500);
    }
}


}
