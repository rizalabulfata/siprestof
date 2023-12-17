<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Unit;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MahasiswaPIFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = json_decode(File::get('database/seeders/mahasiswa/records.json'), true);

        // regions
        $regions = DB::table('districts')->get(['id'])->toArray();
        $regions = json_decode(json_encode($regions), true);
        $regions = array_column($regions, 'id');

        // prodi PIF (dari seeder)
        $prodi = 4;

        // simpan data user dan buat record mahasiswa
        $mahasiswas = [];
        foreach ($records as $record) {
            $nim = $record['nim'];
            $angkatan = substr($nim, 0, 2);
            $tahunAngkatan = Carbon::createFromFormat('y', $angkatan)->format('Y');
            $user = UserFactory::new()->create([
                'role_id' => 2,
                'name' => $record['name'],
                'email' => $nim . '@mail.com',
                'password' => $nim
            ]);
            $record['user_id'] =  $user->id;
            $record['region_id'] = fake()->randomElement($regions);
            $record['unit_id'] = $prodi;
            $record['address'] = fake()->address;
            $record['email'] = $user->email;
            $record['no_hp'] = fake()->phoneNumber;
            $record['last_edu'] = 'sma';
            $record['birth_date'] = fake()->dateTimeBetween('-20 years', '-19 years');
            $record['valid_date'] = $tahunAngkatan . '1';

            $mahasiswas[] = $record;
        }

        // simpan record mahasiswa
        foreach ($mahasiswas as $record) {
            Mahasiswa::create($record);
        }
    }
}
