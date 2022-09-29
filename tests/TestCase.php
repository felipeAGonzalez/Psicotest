<?php

namespace Tests;

use App\User;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser($make = [])
    {
        $user = User::factory()->make($make);
        $user->save();

        return $user;
    }
}
