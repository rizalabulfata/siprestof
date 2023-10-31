<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Unit;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user mahasiswa
        $users = UserFactory::new()->count(10)->create([
            'role_id' => 2
        ]);

        // regions
        $regions = DB::table('districts')->get(['id'])->toArray();
        $regions = json_decode(json_encode($regions), true);
        $regions = array_column($regions, 'id');

        // prodi
        $units = Unit::where('level', '=', 'prodi')->get(['id'])->toArray();
        $units = json_decode(json_encode($units), true);
        $units = array_column($units, 'id');

        foreach ($users as $user) {
            Mahasiswa::create([
                'user_id' => $user->id,
                'region_id' => fake()->randomElement($regions),
                'unit_id' => fake()->randomElement($units),
                'name' => $user->name,
                'nim' => fake()->numerify('#############'),
                'address' => fake()->address,
                'email' => $user->email,
                'no_hp' => fake()->phoneNumber,
                'last_edu' => fake()->randomElement(['sd', 'smp', 'sma']),
                'birth_date' => fake()->dateTimeBetween('-20 years', '-19 years'),
                'valid_date' => now()->addYears(4)->format('Y')
            ]);
        }
    }
}
