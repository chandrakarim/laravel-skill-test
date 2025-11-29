<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::post('/api-login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => auth()->user(),
        ]);
    });

    Route::post('/api-logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out',
        ]);
    });

});
