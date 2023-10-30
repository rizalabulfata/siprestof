<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::unguard();
        $units = json_decode(File::get('database/seeders/unit/records.json'), true);

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
