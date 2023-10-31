<?php

namespace Database\Seeders;

use App\Models\HKFilm;
use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class HKFilmSeeder extends Seeder
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

        $genre = ['fiksi', 'comedy', 'sci-fi', 'horror', 'science', 'biography', 'history'];
        $status = ['pending', 'approve', 'reject'];

        for ($i = 0; $i < 20; $i++) {
            HKFilm::create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'name' => 'Film ' . fake()->words(4, true),
                'genre' => fake()->randomElement($genre),
                'desc' => fake()->sentences(30, true),
                'date' => fake()->date(),
                'url' => fake()->url,
                'approval_status' => fake()->randomElement($status)

            ]);
        }
    }
}
