<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['developer', 'super-admin', 'osas', 'sbo-adviser', 'sbo-student', 'deans', 'campus-director' ,'vpaa', 'guest'];
        foreach($roles as $role){
            Role::create([
                'name'=> $role,
            ]);
        }


        $password = Hash::make('@password2!!');


        $users = [
            [
               'first_name'=> 'osas1',
               'last_name'=> 'account',
                'email' => 'osas1@gmail.com',
                'role' => 'osas',
            ],
            [
               'first_name'=> 'osas2',
               'last_name'=> 'account',
                'email' => 'osa2@gmail.com',
                'role' => 'osas',
            ],
            [
               'first_name'=> 'adviser1',
               'last_name'=> 'account',
                'email' => 'adviser1@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'adviser2',
               'last_name'=> 'account',
                'email' => 'adviser1@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'campus1',
               'last_name'=> 'account',
                'email' => 'campus1@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'campus2',
               'last_name'=> 'account',
                'email' => 'campus2@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'dean1',
               'last_name'=> 'account',
                'email' => 'dean1@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'dean2',
               'last_name'=> 'account',
                'email' => 'dean2@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'vpa1',
               'last_name'=> 'account',
                'email' => 'vpa1@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'vpa2',
               'last_name'=> 'account',
                'email' => 'vpa2@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'student1',
               'last_name'=> 'account',
                'email' => 'student1@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'student2',
               'last_name'=> 'account',
                'email' => 'student2@gmail.com',
                'role' => 'guest'
            ],
            [
               'first_name'=> 'developer',
               'last_name'=> 'account',
                'email' => 'developer@gmail.com',
                'role' => 'developer'
            ],
            [
               'first_name'=> 'superadmin',
               'last_name'=> 'account',
                'email' => 'superadmin@gmail.com',
                'role' => 'super-admin'
            ],
        ];

        foreach($users as $user ){

            $newUser = User::create([
                'first_name'=> $user['first_name'],
                'last_name'=> $user['last_name'],
                'email' => $user['email'],
                'password' => $password,
            ]);
            
            $role = Role::where('name', $user['role'])->first();
            $newUser->roles()->attach($role);
            
            
            
        }
    }
}
