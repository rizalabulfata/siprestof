<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswas = Mahasiswa::get(['id'])->toArray();
        $mahasiswas = array_column($mahasiswas, 'id');

        foreach ($mahasiswas as $mhsId) {
            Kelas::create([
                'mahasiswa_id' => $mhsId,
                'periode' => now()->format('Y') . fake()->randomElement([1, 2]),
                'kelas' => fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F']),
            ]);
        }
    }
}
