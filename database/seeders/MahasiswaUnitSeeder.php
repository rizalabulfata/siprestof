<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswas = Mahasiswa::get();
        $units = Unit::where('level', '=', 'prodi')->get(['id'])->toArray();
        $units = json_decode(json_encode($units), true);
        $units = array_column($units, 'id');

        foreach ($mahasiswas as $mahasiswa) {
            DB::table('mahasiswa_unit')->insert([
                'mahasiswa_id' => $mahasiswa->id,
                'unit_id' => fake()->randomElement($units),
                'periode' => now()->format('Y') . fake()->randomElement(['1', '2']),
                'created_at' => now(),
                'update_at' => now()
            ]);
        }
    }
}
