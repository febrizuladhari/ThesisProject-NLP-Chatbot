<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Personal;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::where('role', 'user')->first();

        $user = User::create([
            'role_id' => $userRole->id,
            'username' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user12345'),
            'is_profile_completed' => true,
        ]);

        Personal::create([
            'user_id' => $user->id,
            'first_name' => 'User',
            'last_name' => 'Satu',
            'phone' => '089876543210',
            'birth_date' => '2003-03-15',
            'gender' => 'female',
        ]);
    }
}
