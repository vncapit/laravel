<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 09:22
 */

namespace App\Modules\User\Service;
use App\Models\User;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Repository\UserRepository;

class UserService
{
    private $userRespository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRespository = $userRepository;
    }

    public function createUser(User $user)
    {
        $res = $this->userRespository->findUserByUsername($user->username);
        if (!$res) {
            return $user->save();
        }
        return UserErrorCode::USERNAME_EXISTED;
    }

    public function userInfo($id=null, $username=null)
    {
        if ($id !== null) {
            $user = $this->userRespository->findUserById($id);
            if ($user) {
                return $user;
            }
            return UserErrorCode::USER_NOT_EXIST;
        }
        $user = $this->userRespository->findUserByUsername($username);
        if ($user) {
            return $user;
        }
        return UserErrorCode::USER_NOT_EXIST;
    }
}
