<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => 'test dosen',
            'email' => 'dosen@mail.com',
            'email_verified_at' => now(),
            'password' => 'dosentest123',
            'is_active' => true,
        ]);
    }
}
