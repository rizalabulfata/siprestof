<?php

namespace Database\Seeders;

use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Database\Factories\OrganisasiFactory;
use Illuminate\Database\Seeder;

class OrganisasiSeeder extends Seeder
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

        $kodifikasi = Kodifikasi::where('id', '>=', 16)->get(['id'])->toArray();
        $kodifikasi = array_column($kodifikasi, 'id');

        for ($i = 0; $i < 20; $i++) {
            OrganisasiFactory::new()->create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas)
            ]);
        }
    }
}
