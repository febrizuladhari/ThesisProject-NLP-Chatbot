<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Personal;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('role', 'admin')->first();

        $admin = User::create([
            'role_id' => $adminRole->id,
            'username' => 'admin',
            'email' => 'admin@chatbot.com',
            'password' => Hash::make('admin123'),
            'is_profile_completed' => true,
        ]);

        Personal::create([
            'user_id' => $admin->id,
            'first_name' => 'Admin',
            'last_name' => 'System',
            'phone' => '081234567890',
            'birth_date' => '2002-02-23',
            'gender' => 'male',
        ]);
    }
}
