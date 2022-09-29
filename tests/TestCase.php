<?php

namespace Tests;
use App\User;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function auth($root = 1, $http = 0, $workArea = '', $assignId = '', $user = null)
    {
        if (! $user) {
            $user = User::factory()->make(['is_root' => $root]);
            $user->save();
        }
        $this->credentials = [
            'user_id' => $user->user_id,
            'name' => $user->name,
            'last_name_1' => $user->last_name_1,
            'last_name_2' => $user->last_name_2,
            'email_verified_at' => $user->email_verified_at,
            'need_change_password' => $user->need_change_password,
            'is_root' => $user->is_root,
            'status' => $user->status,
            'email' => $user->email,
            'password' => '@12345',
            'preferred_language' => $user->preferred_language,
        ];
    }

    public function createUser($make = [])
    {
        $user = User::factory()->make($make);
        $user->save();

        return $user;
    }
}
