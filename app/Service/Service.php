<?php

namespace App\Service;

use App\Models\HKAplikom;
use App\Models\HKArtikel;
use App\Models\HKBuku;
use App\Models\HKDesainProduk;
use App\Models\HKFilm;
use App\Models\Kelas;
use App\Models\Kodifikasi;
use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Organisasi;
use App\Models\Penghargaan;

class Service
{
    protected $table_kelas;
    protected $table_kodifikasi;
    protected $table_kompetisi;
    protected $table_mahasiswa;
    protected $table_organisasi;
    protected $table_penghargaan;
    protected $table_hkaplikom;
    protected $table_hkartikel;
    protected $table_hkbuku;
    protected $table_hkdesainproduk;
    protected $table_hkfilm;

    public function __construct()
    {
        $this->table_kelas = (new Kelas())->getTable();
        $this->table_kodifikasi = (new Kodifikasi())->getTable();
        $this->table_kompetisi = (new Kompetisi())->getTable();
        $this->table_mahasiswa = (new Mahasiswa())->getTable();
        $this->table_organisasi = (new Organisasi())->getTable();
        $this->table_penghargaan = (new Penghargaan())->getTable();
        $this->table_hkaplikom = (new HKAplikom())->getTable();
        $this->table_hkartikel = (new HKArtikel())->getTable();
        $this->table_hkbuku = (new HKBuku())->getTable();
        $this->table_hkdesainproduk = (new HKDesainProduk());
        $this->table_hkfilm = (new HKFilm());
    }
}
