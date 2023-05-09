<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 15:38
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Modules\Auth\ErrorCode\AuthErrorCode;
use App\Modules\Auth\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => 'required|string',
                'password' => 'required|string'
            ]);
        }
        catch (ValidationException $e){
            $error = json_encode($e->errors());
            return $this->failed(422, $error);
        }

        $data = $this->authService->login($request);

        if ($data !== AuthErrorCode::USERNAME_OR_PASSWORD_INCORRECT) {
            return $this->success($data);
        }

        return $this->failed($data, AuthErrorCode::getText($data));
    }

    public function logout() {
        return $this->authService->logout();
    }
}
