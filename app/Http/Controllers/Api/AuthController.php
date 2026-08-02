<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
  
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé',
            'user' => $user,
            'token' => $token
        ], 201);


    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login réussi',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    // 👤 USER CONNECTÉ
    public function user(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Déconnecté avec succès'
        ]);
    }


    public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name' => 'required',
        'telephone' => 'nullable',
        'adresse' => 'nullable',
    ]);

    $user->update([
        'name' => $request->name,
        'telephone' => $request->telephone,
        'adresse' => $request->adresse,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Profil mis à jour',
        'user' => $user
    ]);
}



public function updatePhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = $request->user();

    if ($user->photo) {
        Storage::disk('public')->delete($user->photo);
    }

    $path = $request->file('photo')->store('profiles', 'public');

    $user->update([
        'photo' => $path,
    ]);

    return response()->json([
        'status' => true,
        'photo' => $path,
    ]);
}



}