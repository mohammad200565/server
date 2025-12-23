<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends BaseApiController
{
    private function hitRateLimiter(Request $request)
    {
        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ["Too many attempts. Try again in $seconds seconds."],
            ]);
        }
        return $key;
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $key = $this->hitRateLimiter($request);
        RateLimiter::hit($key, 60);
        $user = User::where('phone', $data['phone'])
            ->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.']
            ]);
        }
        $user->tokens()->delete();
        $tokenResult = $user->createToken('api-token');
        $token = $tokenResult->plainTextToken;
        $tokenModel = $user->tokens()->latest()->first();
        $tokenModel->expires_at = now()->addHours(24);
        $tokenModel->save();

        RateLimiter::clear($key);
        return $this->successResponse("Login successful", [
            'user'  => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $key = $this->hitRateLimiter($request);
        RateLimiter::hit($key, 60);

        $profilePath = null;
        $personIdPath = null;
        if ($request->hasFile('profileImage')) {
            $profilePath = $request->file('profileImage')->store('users/profile', 'public');
        }
        if ($request->hasFile('personIdImage')) {
            $personIdPath = $request->file('personIdImage')->store('users/personId', 'public');
        }

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        RateLimiter::clear($key);
        $user->tokens()->delete();
        $tokenResult = $user->createToken('api-token');
        $token = $tokenResult->plainTextToken;
        $tokenModel = $user->tokens()->latest()->first();
        $tokenModel->expires_at = now()->addHours(24);
        $tokenModel->save();

        return $this->successResponse("Register successful", [
            'user'  => new UserResource($user),
            'token' => $token,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->successResponse("Logged out successfully");
    }

    public function me(Request $request)
    {
        return $this->successResponse("User retrieved successfully", new UserResource($request->user()));
    }
}
