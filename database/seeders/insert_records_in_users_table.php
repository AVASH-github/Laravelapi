<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class insert_records_in_users_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users= [
            [
                'name'=>'avash',
            'email'=>'avashnepal123@gmail.com',
            'password'=>bcrypt('12345')
        ],

            [
                'name'=>'test',
            'email'=>'testhnepal123@gmail.com',
            'password'=>bcrypt('123456'), 
        ],
];
User::insert($users);
    }
}

