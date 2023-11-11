<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\isEmpty;

class VerifikasiService extends Service
{
    /**
     * ambil seluruh data portofolio mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListVerifikasiIndex($n = 10, $p = null, $authCheck = false, $conditions = [], $conditionsIn = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        $p = $p ?: (Paginator::resolveCurrentPage() ?: 1);
        $n = $n <= 0 ? -1 : $n;

        // ambil pending prestasi
        // $prestasiService = new PrestasiService();
        // $prestasi = $prestasiService->getPendingPrestasi();

        // ambil pending portofolio
        $portoService = new PortofolioService();
        $mhsId = null;
        if (Gate::allows('isMahasiswa')) {
            $mhsId = auth()->user()->mahasiswa->id;
        }

        $porto = $portoService->getPendingPortofolio($mhsId);
        $result = collect($porto->toArray());
        // $result = collect(array_merge($prestasi->toArray(), $porto->toArray()));
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                if ($value) {
                    $result = $result->where($key, '=', $value);
                }
            }
        }
        if (!empty($conditionsIn)) {
            foreach ($conditionsIn as $key => $value) {
                if (!empty($value)) {
                    $result = $result->whereIn($key, $value);
                }
            }
        }

        return new LengthAwarePaginator($result->forPage($p, $n), $result->count(), $n, $p, [
            'path' => route('verifikasi.index'),
            'pageName' => 'p'
        ]);
    }

    /**
     * Tampilkan detail data verifikasi
     * @return \App\Models\Model
     */
    public function showDetailVerifikasi($id, $type)
    {
        $tables = [
            'aplikom' => $this->table_hkaplikom,
            'artikel' => $this->table_hkartikel,
            'buku' => $this->table_hkbuku,
            'desain_produk' => $this->table_hkdesainproduk,
            'film' => $this->table_hkfilm,
            'kompetisi' => $this->table_kompetisi,
            'penghargaan' => $this->table_penghargaan,
            'organisasi' => $this->table_organisasi
        ];
        $columnName = [
            'aplikom' => 'bentuk_aplikom',
            'desain_produk' => 'bentuk_desain'
        ];
        $cname = 'name';
        if (isset($columnName[$type])) {
            $cname = $columnName[$type];
        }

        $columns = [
            $this->table_kodifikasi . '.code as kod_code',
            $this->table_kodifikasi . '.second_name as kod_second_name',
            $this->table_kodifikasi . '.kategori as kod_kategori',
            $this->table_kodifikasi . '.skor',
            $this->table_mahasiswa . '.nim as mhs_nim',
            $this->table_mahasiswa . '.name as mhs_name',
            $tables[$type] . '.' . $cname . ' as event',
            $tables[$type] . '.*'
        ];

        $record = DB::table($tables[$type])
            ->join($this->table_kodifikasi, $this->table_kodifikasi . '.id', '=', $tables[$type] . '.kodifikasi_id')
            ->join($this->table_mahasiswa, $this->table_mahasiswa . '.id', '=', $tables[$type] . '.mahasiswa_id')
            ->where($tables[$type] . '.id', '=', $id)
            ->first($columns);
        return $record;
    }
}
