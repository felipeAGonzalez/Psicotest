<?php

namespace Database\Factories;

use App\Helpers\Utils;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;
        $lastName1 = $this->faker->lastName;
        $lastName2 = $this->faker->lastName;

    return [
        'name' => $name,
        'last_name_1' => $lastName1,
        'last_name_2' => $lastName2,
        'email' => $this->faker->randomNumber(5).$this->faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('@12345'),
        'is_root' => 1,
        'archived' => 0,
        'remember_token' => Str::random(10),

    ];
    }
}
