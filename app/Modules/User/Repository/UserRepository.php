<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 09:26
 */

namespace App\Modules\User\Repository;
use App\Models\User;

class UserRepository
{
    /**
     * Notes: Find user by id
     * User: Cap
     * Date: 2023/05/09 10:09
     *
     * @param $id
     * @return mixed
     */
    public function findUserById($id)
    {
        return User::find($id);
    }

    /**
     * Notes: Find user by username
     * User: Cap
     * Date: 2023/05/09 10:09
     *
     * @param $username
     * @return mixed
     */
    public function findUserByUsername($username)
    {
        return User::where('username',$username)->first();
    }
}
