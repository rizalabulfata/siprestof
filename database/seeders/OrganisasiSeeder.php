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
        $status = ['pending', 'approve', 'reject'];

        for ($i = 0; $i < 20; $i++) {
            $model = OrganisasiFactory::new()->create([
                'kodifikasi_id' => fake()->randomElement($kodifikasi),
                'mahasiswa_id' => fake()->randomElement($mahasiswas),
                'approval_status' => fake()->randomElement($status)
            ]);
            $time = fake()->dateTimeThisYear();
            $model->created_at = $time;
            $model->updated_at = $time;
            $model->save();
        }
    }
}
