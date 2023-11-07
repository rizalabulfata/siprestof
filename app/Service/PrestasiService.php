<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PrestasiService extends Service
{
    /**
     * ambil seluruh data kompetisi mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListPrestasi($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        return Kompetisi::with($relations)->where($conditions)->orderBy($order[0], $order[1])->paginate($n, $columns);
    }

    /**
     * ambil seluruh data portofolio mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListPrestasiView($n = 10, $p = null, $checkAuth = false, $conditions = [], $search_filters = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        $p = $p ?: (Paginator::resolveCurrentPage() ?: 1);
        $n = $n <= 0 ? -1 : $n;

        $columns = [
            $this->table_mahasiswa . '.id',
            $this->table_mahasiswa . '.nim',
            $this->table_mahasiswa . '.name',
            // DB::raw('count(*) as total'),
        ];
        $tables = [$this->table_kompetisi => 'name', $this->table_penghargaan => 'name'];

        $mhs = DB::table($this->table_mahasiswa);
        if ($checkAuth) {
            $user = auth()->user();
            if ($user->mahasiswa) {
                $mhs->where('id', '=', $user->mahasiswa_id);
            }
        }
        $mhs = $mhs->get($columns);

        $result = [];
        foreach ($mhs as $m) {
            $result[$m->id] = json_decode(json_encode($m), true);
            $result[$m->id]['data'] = [];
            $result[$m->id]['total'] = 0;
            foreach ($tables as $table => $name) {
                $records = DB::table($table)->where([
                    ['mahasiswa_id', $m->id],
                    ['approval_status', Model::APPROVE],
                ])->get(['id as event_id', $name . ' as event_name'])->each(function ($item) use ($table) {
                    $item->type = str_replace('hk_', '', $table);
                })->toArray();
                if ($records) {
                    $result[$m->id]['data'] = array_merge(
                        $result[$m->id]['data'],
                        json_decode(json_encode($records), true)
                    );
                }
            }
            $result[$m->id]['total'] = count($result[$m->id]['data']);
        }
        $result = collect($result);

        return new LengthAwarePaginator($result->forPage($p, $n), $result->count(), $n, $p, [
            'path' => route('prestasi.index'),
            'pageName' => 'p'
        ]);
    }

    /**
     * Tampilkan portoflio mahasiswa
     * @param int $id
     * @return \App\Models\Mahasiswa
     */
    public function showPrestasi($id)
    {
        $table_kompetisi = $this->table_kompetisi;
        $table_kodifikasi = $this->table_kodifikasi;
        $table_penghargaan = $this->table_penghargaan;

        $kompetisi = DB::table($table_kompetisi)
            ->join($table_kodifikasi, $table_kodifikasi . '.id', '=', $table_kompetisi . '.kodifikasi_id')
            ->where('mahasiswa_id', '=', $id)
            ->where('approval_status', '=', Model::APPROVE)
            ->get([
                $table_kompetisi . '.id',
                $table_kompetisi . '.name as name',
                $table_kodifikasi . '.kategori',
                $table_kodifikasi . '.code',
                $table_kompetisi . '.organizer',
                $table_kompetisi . '.year',
                $table_kompetisi . '.desc',
                $table_kompetisi . '.documentation',
                $table_kompetisi . '.certificate',
            ])
            ->each(function ($item) use ($table_kompetisi) {
                $item->type = $table_kompetisi;
                $item->code = $item->code . str_pad($item->id, 5, 0, STR_PAD_LEFT);
            })->toArray();
        $penghargaan = DB::table($table_penghargaan)
            ->join($table_kodifikasi, $table_kodifikasi . '.id', '=', $table_penghargaan . '.kodifikasi_id')
            ->where('mahasiswa_id', '=', $id)
            ->where('approval_status', '=', Model::APPROVE)
            ->get([
                $table_penghargaan . '.id',
                $table_penghargaan . '.name as name',
                $table_kodifikasi . '.kategori',
                $table_kodifikasi . '.code',
                $table_penghargaan . '.institution as organizer',
                $table_penghargaan . '.date',
                $table_penghargaan . '.desc',
                $table_penghargaan . '.certificate',
            ])
            ->each(function ($item) use ($table_penghargaan) {
                $item->year = Carbon::parse($item->date)->format('Y');
                $item->type = $table_penghargaan;
                $item->code = $item->code . str_pad($item->id, 5, 0, STR_PAD_LEFT);
            })->toArray();
        $records = array_merge($kompetisi, $penghargaan);
        $result = [];
        foreach ($records as $record) {
            $result[] = (object)[
                'code' => $record->code,
                'details' => $record
            ];
        }

        return $result;
    }

    /**
     * Tampilkan list prestasi belum di approve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingPrestasi()
    {
        $columns = [
            $this->table_mahasiswa . '.id',
            $this->table_mahasiswa . '.nim',
            $this->table_mahasiswa . '.name'
        ];

        $komp_kolom = $columns;
        $komp_kolom[] = $this->table_kompetisi . '.id as event_id';
        $komp_kolom[] = $this->table_kompetisi . '.name as event';
        $komp_kolom[] = $this->table_kompetisi . '.created_at';
        $kompetisi = DB::table($this->table_mahasiswa)
            ->join($this->table_kompetisi, $this->table_kompetisi . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_kompetisi . '.approval_status', '=', Model::PENDING)
            ->get($komp_kolom);
        $kompetisi->each(function ($item) {
            $item->type = 'kompetisi';
        });

        $peng_kolom = $columns;
        $peng_kolom[] = $this->table_penghargaan . '.id as event_id';
        $peng_kolom[] = $this->table_penghargaan . '.name as event';
        $peng_kolom[] = $this->table_penghargaan . '.created_at';
        $penghargaan = DB::table($this->table_mahasiswa)
            ->join($this->table_penghargaan, $this->table_penghargaan . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_penghargaan . '.approval_status', '=', Model::PENDING)
            ->get($peng_kolom);
        $penghargaan->each(function ($item) {
            $item->type = 'penghargaan';
        });

        $records = collect(array_merge($kompetisi->toArray(), $penghargaan->toArray()))->sortBy('created_at', SORT_REGULAR, true);
        return $records;
    }

    /**
     * Tampilkan detail prestasi
     */
    public function showDetailPrestasi($id, $type)
    {
        $record = DB::table($type)
            ->where('id', '=', $id)
            ->first();
        return $record;
    }
}
