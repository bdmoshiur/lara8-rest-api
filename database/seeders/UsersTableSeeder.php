<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=> 'moshiur Rahman1', 'email'=>'moshiurcse888@gmail.com','password'=>'123454678'],
            ['name'=> 'moshiur Rahman2', 'email'=>'moshiurcse88@gmail.com','password'=>'123454678'],
            ['name'=> 'moshiur Rahman3', 'email'=>'moshiurcse8@gmail.com','password'=>'123454678'],
        ];

        User::insert($users);
    }
}
