<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admin = User::create([
            'name' => 'Admin Doe',
            'email' => 'admin@email.com',
            'password' => Hash::make('secret'),
            'role' => User::ROLE_ADMIN,
        ]);

        $admin->profile()->create();

        $member1 = User::create([
            'name' => 'John Doe',
            'email' => 'member@gmail.com',
            'password' => Hash::make('secret'),
            'role' => User::ROLE_MEMBER,
        ]);

        $member1->profile()->create();
        
        $member2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'member2@email.com',
            'password' => Hash::make('secret'),
            'role' => User::ROLE_MEMBER,
        ]);
        $member2->profile()->create();
    }
}
