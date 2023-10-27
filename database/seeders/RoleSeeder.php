<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'dosen' => [
                'code' => 'dosen',
                'name' => 'Dosen'
            ],
            'mhs' => [
                'code' => 'mahasiswa',
                'name' => 'Mahasiswa'
            ],
        ];

        foreach ($roles as $code => $role) {
            Role::create($role);
        }
    }
}
