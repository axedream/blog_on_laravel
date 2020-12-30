<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use function Symfony\Component\String\b;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'name' => 'Автор не известен',
                'email'=> 'autor_unk@g.g',
                'password' => bcrypt('dsfsdf'.rand(10,100)),
            ],
            [
                'name' => 'Автор',
                'email' => 'autor@email.g',
                'password'=> bcrypt('123123'),
            ]
        ];

        \DB::table('users')->insert($data);

    }
}
