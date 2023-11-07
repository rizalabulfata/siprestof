<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class VerifikasiService extends Service
{
    /**
     * ambil seluruh data portofolio mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListVerifikasiIndex($n = 10, $p = null, $conditions = [], $conditionsIn = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        $p = $p ?: (Paginator::resolveCurrentPage() ?: 1);
        $n = $n <= 0 ? -1 : $n;

        // ambil pending prestasi
        $prestasiService = new PrestasiService();
        $prestasi = $prestasiService->getPendingPrestasi();

        // ambil pending portofolio
        $portoService = new PortofolioService();
        $porto = $portoService->getPendingPortofolio();
        $result = collect(array_merge($prestasi->toArray(), $porto->toArray()));
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
}
