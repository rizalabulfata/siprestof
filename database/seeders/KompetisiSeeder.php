<?php

namespace Database\Seeders;

use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Database\Factories\KompetisiFactory;
use Exception;
use Illuminate\Database\Seeder;

class KompetisiSeeder extends Seeder
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

        $kodifikasi = Kodifikasi::where('bidang', '=', 'kompetisi')->get(['id'])->toArray();
        $kodifikasi = array_column($kodifikasi, 'id');

        $status = ['pending', 'approve', 'reject'];

        for ($i = 0; $i < 20; $i++) {
            KompetisiFactory::new()->create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'approval_status' => fake()->randomElement($status)
            ]);
        }
    }
}
