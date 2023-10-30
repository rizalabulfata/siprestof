<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'username' => 'admin',
        //     'firstname' => 'Admin',
        //     'lastname' => 'Admin',
        //     'email' => 'admin@argon.com',
        //     'password' => bcrypt('secret')
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(AuthDatabaseSeeder::class);

        // optional seeder
        $this->call(PegawaiSeeder::class);
        $this->call(MahasiswaSeeder::class);
        $this->call(MahasiswaUnitSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(KodifikasiSeeder::class);
        $this->call(KompetisiSeeder::class);
        $this->call(OrganisasiSeeder::class);
        $this->call(PenghargaanSeeder::class);
        $this->call(HKBukuSeeder::class);
        $this->call(HKArtikelSeeder::class);
        $this->call(HKDesainProdukSeeder::class);
        $this->call(HKFilmSeeder::class);
        $this->call(HKAplikomSeeder::class);
    }
}
