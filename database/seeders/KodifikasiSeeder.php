<?php

namespace Database\Seeders;

use App\Models\Kodifikasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class KodifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = json_decode(File::get('database/seeders/kodifikasi/records.json'), true);

        foreach ($records as $data) {
            Kodifikasi::create($data);
        }
    }
}
