<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'prueba@felipe.mx';
        $user = DB::table('users')->where('email', $email)->first();

        if ($user == null) {
            DB::table('users')->insert([
                'name' => 'Felipe',
                'last_name_1' => 'Gonzalez',
                'email' => $email,
                'password' => bcrypt(env('APP_USER_PASSWORD', '1234')),
                'need_change_password' => false,
                'is_root' => true,
                'archived' => false,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
