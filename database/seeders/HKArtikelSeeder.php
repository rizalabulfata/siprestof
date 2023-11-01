<?php

namespace Database\Seeders;

use App\Models\HKArtikel;
use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class HKArtikelSeeder extends Seeder
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
            HKArtikel::create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'name' => fake()->words(15, true),
                'publisher' => fake()->company,
                'issue_at' => fake()->dateTimeThisYear(),
                'url' => fake()->url,
                'approval_status' => fake()->randomElement($status)
            ]);
        }
    }
}
