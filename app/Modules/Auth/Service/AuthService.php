<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 16:12
 */

namespace App\Modules\Auth\Service;


use App\Modules\Auth\ErrorCode\AuthErrorCode;
use App\Modules\User\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function login($request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = $this->userRepository->findUserByUsername($username);
        if (!$user) {
            return AuthErrorCode::USERNAME_OR_PASSWORD_INCORRECT;
        }

        if (Hash::check($password, $user->password)) {
            return $user->createToken('auth')->plainTextToken;
        }
        return AuthErrorCode::USERNAME_OR_PASSWORD_INCORRECT;
    }

    public function logout()
    {
        return api_user()->currentAccessToken()->delete();
    }
}
