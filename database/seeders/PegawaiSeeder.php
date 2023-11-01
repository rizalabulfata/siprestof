<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Database\Factories\UserFactory;
use Database\Factories\UserPegawaiFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user dosen
        $users = UserFactory::new()->count(3)->create([
            'role_id' => 1
        ]);

        // regions
        $regions = DB::table('districts')->get(['id'])->toArray();
        $regions = json_decode(json_encode($regions), true);
        $regions = array_column($regions, 'id');

        foreach ($users as $user) {
            Pegawai::create([
                'user_id' => $user->id,
                'region_id' => fake()->randomElement($regions),
                'address' => fake()->address,
                'email' => $user->email,
                'no_hp' => trim(fake()->phoneNumber, ' ')
            ]);
        }
    }
}
