<?php

namespace Tests\Feature\UserController;

use App\Helpers\Lang;
use App\Exceptions\FieldsException;
use App\Http\Middleware\HasWorkAreaMiddleware;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Pruebas para comprobar el funcionamiento del
 * método App\Http\Controllers\UserController.php:register.
 *
 *
 * @method-doc POST
 * @path-doc /api/user/
 */
class DeleteTest extends TestCase
{
    use WithFaker;

    /**
      * Caso cuando se elimina un usuario correctamente.
      *
      * @title-doc Eliminar un usuario
      * @description-doc En este ejemplo se elimina un usuario en especifico
      */
    public function testDeleteUsersWithPermits()
    {
        $adviceMessage = 'api.user_deleted';
        $user = User::create(['name' => $this->faker->name,
        'last_name_1' => $this->faker->lastName,
        'last_name_2' => $this->faker->lastName,
        'email' => $this->faker->safeEmail,
        'password' => $this->faker->password(8),
        'need_change_password' => 0,]);
        // $user=User::where('name')
        error_log(print_r($user, true));
        $response = $this->delete('/api/user/'.$user->user_id);
        $response->assertJson([
            'status' => true,
            'data' => Lang::get($adviceMessage),
        ]);
        $response->assertStatus(200);
    }
}
