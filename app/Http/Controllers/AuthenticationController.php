<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request, AuthenticationService $auth)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $result = $auth->login($data['username'], $data['password']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return response()->json($result);
    }
}
