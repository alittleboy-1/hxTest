<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UsersService
{
    public function getOne($username, $password)

    {
        return DB::table('users')->where([
            'name' => $username,
            'password' => $password,
        ])->first();
    }
}
