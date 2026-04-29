<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponseTrait;
    public function index(){
        $users = User::all();
        return $this->successApiResponse($users, "Get users successfully!", 200);
    }
    public function login(Request $req)
    {
        $req->validate([
            'email' => "required|email",
            'password' => "required|string|min:6",
            'remember' => "boolean"
        ]);

        $user = User::where('email', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                "message" => "Invalid email or password"
            ], 401);
        }

        $token = $user->createToken("authtoken")->plainTextToken;

        $remember = $req->remember ?? false;
        $minutes = $remember ? 60 * 24 * 7 : 60 * 24;

        $cookie = cookie(
            "auth_token",
            $token,
            $minutes,
            "/",
            null,
            false,
            true,
            false,
            "Strict"
        );

        return response()->json([
            "user" => $user,
            "token" => $token,
            "message" => "User login successfully!"
        ])->withCookie($cookie);
    }
    public function me(Request $req)
    {
        $user = $req->user();

        return response()->json([
            "data" => $user->load('profile'),
            "message" => "Get user successfully!"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role']
        ]);

        $profile = Profile::create([
            'gender' => $validated['gender'] ?? '',
            'phone' => $validated['phone'] ?? '',
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'user_id' => $user->_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully!',
            'data' => [
                'user' => $user,
                'profile' => $profile,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
