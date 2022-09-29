<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id')->comment = 'Identificador único del registro del usuario';
            $table->string('name')->comment = 'Nombre del usuario.';
            $table->string('last_name_1')->comment = 'Apellido 1° del usuario.';
            $table->string('last_name_2')->default(null)->nullable()->comment = 'Apellido 2° del usuario. Por defecto el valor es nulo';
            $table->string('email')->unique()->comment = 'Correo del usuario, este es único.';
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment = 'Contraseña del usuario.';
            $table->boolean('need_change_password')->default(true)->comment = 'Bandera que determina si el usuario debe cambiar su contraseña.';
            $table->boolean('is_root')->default(false)->comment = 'Bandera que determina si el usuario es Root.';
            $table->boolean('archived')->default(false)->comment = 'Bandera para saber si el registro fue eliminado. Por defecto el valor es False.';
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
