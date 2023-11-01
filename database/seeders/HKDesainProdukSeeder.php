<?php

namespace Database\Seeders;

use App\Models\HKDesainProduk;
use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class HKDesainProdukSeeder extends Seeder
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

        $kodifikasi = Kodifikasi::where('bidang', '=', 'karya')->get(['id'])->toArray();
        $kodifikasi = array_column($kodifikasi, 'id');
        $status = ['pending', 'approve', 'reject'];

        for ($i = 0; $i < 20; $i++) {
            HKDesainProduk::create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'bentuk_desain' => fake()->words(10, true),
                'year' => fake()->numberBetween(2010, 2020),
                'mockup' => json_encode([
                    ['name' => 'certificate.jpg'],
                    ['name' => 'dummy.pdf']
                ]),
                'approval_status' => fake()->randomElement($status)
            ]);
        }
    }
}
