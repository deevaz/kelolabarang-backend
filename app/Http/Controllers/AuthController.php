<?php

namespace App\Http\Controllers;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profilePicturePath = 'https://kelola.abdaziz.my.id/' . $profilePicturePath;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'profile_picture' => $profilePicturePath,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        if (!User::where('username', $credentials['username'])->exists()) {
            return response()->json(['error' => 'Username tidak ditemukan'], 404);
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Password salah'], 401);
        }

        return response()->json([
            'message' => 'Login Berhasil',
            'user' => auth()->user(),
            'token' => $token
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Berhasil Logout']);
    }

    public function refresh()
    {
        return response()->json([
            'token' => JWTAuth::refresh()
        ]);
    }

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'            => 'sometimes|required|string|max:255',
            'username'        => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
            'email'           => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'        => 'sometimes|required|string|min:6',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('username')) {
            $user->username = $request->username;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $profilePicturePath;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($user->profile_picture) {
            $user->profile_picture = 'https://kelola.abdaziz.my.id/' . $user->profile_picture;
        }

        return response()->json([
            'message' => 'Profil berhasil di perbarui',
            'user'    => $user,
        ]);
    }

    public function deleteAccount()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $user->delete();

        return response()->json([
            'message' => 'Akun berhasil dihapus',
        ]);
    }
}
