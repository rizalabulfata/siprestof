<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'password' => bcrypt('12345678'),
            'is_active' => true,
        ]);
    }
}
