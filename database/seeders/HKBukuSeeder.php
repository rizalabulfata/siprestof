<?php

namespace Database\Seeders;

use App\Models\HKBuku;
use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class HKBukuSeeder extends Seeder
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

        $type = ['fiksi', 'ilmiah', 'sci-fi', 'horro', 'science', 'pendidikan', 'informatika'];
        $status = ['pending', 'approve', 'reject'];

        for ($i = 0; $i < 20; $i++) {
            $model = HKBuku::create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'name' => 'Buku ' . fake()->words(4, true),
                'type' => fake()->randomElement($type),
                'publisher' => fake()->company,
                'isbn' => fake()->uuid,
                'page_total' => fake()->numberBetween(50, 300),
                'year' => fake()->numberBetween(2010, 2020),
                'documentation' => json_encode([
                    ['name' => 'certificate.jpg'],
                    ['name' => 'dummy.pdf']
                ]),
                'approval_status' => fake()->randomElement($status)
            ]);
            $time = fake()->dateTimeThisYear();
            $model->created_at = $time;
            $model->updated_at = $time;
            $model->save();
        }
    }
}
