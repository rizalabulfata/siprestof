<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class DashboardService extends Service
{
    /**
     * ambil seluruh data kompetisi mahasiswa
     * @return array
     */
    public function getSummary()
    {
        $mhs = DB::table($this->table_mahasiswa)->count();
        $user = DB::table($this->table_user)->count();

        $prestasi = DB::table($this->table_penghargaan)->where('approval_status', '=', Model::APPROVE)->count()
            + DB::table($this->table_kompetisi)->where('approval_status', '=', Model::APPROVE)->count();

        $karya = [
            $this->table_hkaplikom, $this->table_hkartikel, $this->table_hkbuku,
            $this->table_hkdesainproduk, $this->table_hkfilm, $this->table_organisasi
        ];
        $karyaCount = 0;
        foreach ($karya as $table) {
            $karyaCount += DB::table($table)->where('approval_status', '=', Model::APPROVE)->count();
        }

        return [
            'mhs' => $mhs,
            'user' => $user,
            'prestasi' => $prestasi,
            'portofolio' => $karyaCount
        ];
    }
}
