<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;
use App\Models\PersonalAccessToken;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-token', function () {
    $user = App\Models\User::first();
    $token = Str::random(60);

    PersonalAccessToken::create([
        'tokenable_type' => App\Models\User::class,
        'tokenable_id'   => $user->_id,
        'name'           => 'api_token',
        'token'          => hash('sha256', $token),
        'abilities'      => ['*'],
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return $token;
});

Route::get('/login', function () {
    return response()->json(['message' => 'Login route not used, use API tokens instead.']);
})->name('login');

