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
class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * Caso cuando se crea un usuario correctamente
     *
     * @title-doc Registrar nuevo usuario
     * @description-doc En este ejemplo se registra un nuevo  usuario.
     */
    public function testCreateUserWithData()
    {
        $credentials = [
            'name' => $this->faker->name,
            'last_name_1' => $this->faker->lastName,
            'last_name_2' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password(8),
            'need_change_password' => 0,
        ];
        $response = $this->post('/api/user/', $credentials);
        unset($credentials['password']);
        $user = User::where('name', $credentials['name'])->first()->toArray();
        $response->assertJson([
            'status' => true,
            'data' => $user,
        ]);
        $response->assertStatus(201);
    }
}
