<?php

namespace App\Http\Controllers\User;

use App\Modules\User\ErrorCode\UserErrorCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\User\Service\UserService;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Notes: Create user
     * User: Cap
     * Date: 2023/05/09 15:21
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|min:4|max:15',
            'password' => 'required|string|min:6|max:20',
            'email' => 'nullable|email',
            'name' => 'required|string',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $data = $this->userService->createUser($user);
        if ($data !== UserErrorCode::USERNAME_EXISTED) {
            return $this->success($data);
        }
        return $this->failed($data, UserErrorCode::getText($data));
    }


}
