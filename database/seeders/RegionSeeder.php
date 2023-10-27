<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/seeders/region/';

        // file
        $district = json_decode(File::get($path . 'district.json'), true);
        $prov = json_decode(File::get($path . 'provincies.json'), true);
        $reg = json_decode(File::get($path . 'regencies.json'), true);
        $vil = json_decode(File::get($path . 'villages.json'), true);

        $collectVillage = collect($vil)->chunk(10000);

        $tables = [
            'provincies' => $prov,
            'regencies' => $reg,
            'districts' => $district,
        ];

        $this->command->getOutput()->progressStart(count($tables) + $collectVillage->count());
        foreach ($tables as $table => $data) {
            try {
                $resp = DB::table($table)->insert($data);
            } catch (Exception $e) {
                $resp = $e->getMessage();
                Storage::disk('local')->put('app/log_region/' . $table . '-' . time(), $resp);
            }
            $this->command->getOutput()->progressAdvance();
        }

        try {
            foreach ($collectVillage as $village) {
                $resp = DB::table('villages')->insert($village->toArray());
                $this->command->getOutput()->progressAdvance();
            }
        } catch (Exception $e) {
            $resp = $e->getMessage();
        }
        Storage::disk('local')->put('app/log_region/villages-' . time(), $resp);

        $this->command->getOutput()->progressFinish();
    }
}
