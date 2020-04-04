<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$RzNPkSfYdigvt2ezl1tJDubAEK/m0ymuj1VCftDsZ.vxUJ9N6CpI2',
                'remember_token' => null,
            ],
        ];

        User::insert($users);

    }
}
