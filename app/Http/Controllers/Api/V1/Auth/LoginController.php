<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $loginRequest): JsonResponse
    {
        $user = User::where('email', $loginRequest->email)->first();

        if (!$user || !Hash::check($loginRequest->password, $user->password)) {
            return response()->json(['error' => 'login credentials do not match'], 422);
        }
        $device = substr($loginRequest->userAgent() ?? '', 0, 225);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ]);
    }
}
