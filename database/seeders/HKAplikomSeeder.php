<?php

namespace Database\Seeders;

use App\Models\HKAplikom;
use App\Models\Kodifikasi;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class HKAplikomSeeder extends Seeder
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
            $model = HKAplikom::create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'bentuk_aplikom' => 'Aplikasi ' . fake()->words(4, true),
                'desc' => fake()->words(30, true),
                'year' => fake()->numberBetween(2010, 2020),
                'url' => fake()->url,
                'approval_status' => fake()->randomElement($status)
            ]);
            $time = fake()->dateTimeThisYear();
            $model->created_at = $time;
            $model->updated_at = $time;
            $model->save();
        }
    }
}
