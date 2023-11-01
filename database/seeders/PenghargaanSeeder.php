<?php

namespace Database\Seeders;

use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Database\Factories\PenghargaanFactory;
use Illuminate\Database\Seeder;

class PenghargaanSeeder extends Seeder
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

        $kodifikasi = Kodifikasi::where('bidang', '=', 'penghargaan')->get(['id'])->toArray();
        $kodifikasi = array_column($kodifikasi, 'id');
        $status = ['pending', 'approve', 'reject'];

        for ($i = 0; $i < 20; $i++) {
            PenghargaanFactory::new()->create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'approval_status' => fake()->randomElement($status)
            ]);
        }
    }
}
