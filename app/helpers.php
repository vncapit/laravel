<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('api_auth')) {
    function api_auth() {
        return app(\Illuminate\Contracts\Auth\Factory::class)->guard('api');
    }
}

if (!function_exists('api_user')) {
    function api_user() {
        return api_auth()->user();
    }
}

if(! function_exists('api_user_model')) {
    function api_user_model() {
        $userId = api_user()['id'];
        return \App\Models\User::find($userId);
    }
}
