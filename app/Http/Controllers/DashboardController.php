<?php

namespace App\Http\Controllers;

use App\Service\DashboardService;
use App\Service\PortofolioService;
use App\Service\PrestasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    const RESOURCE = 'dashboard';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DashboardService $service)
    {
        // ambil pending prestasi
        // $prestasiService = new PrestasiService();
        // $prestasi = $prestasiService->getPendingPrestasi();
        // $data['prestasi'] = $prestasi;
        // $data['prestasi_total'] = $prestasi->count();

        // ambil pending portofolio
        $portoService = new PortofolioService();
        $order = ['created_at', 'desc'];
        $mhsId = null;
        if (Gate::allows('isMahasiswa')) {
            $mhsId = $this->getAuthActionId();
            $order = ['updated_at', 'desc'];
            $porto = $portoService->getUpdateInformasiPortofolio($mhsId, $order);
        } else {
            $porto = $portoService->getPendingPortofolio($mhsId, $order);
        }

        $data['porto'] = $porto;
        $data['porto_total'] = $porto->count();

        // summary dashboard
        if (Gate::allows('isAdmin')) {
            $data['summary'] = $service->getSummary();
        } else {
            $data['summary'] = $service->getSummaryMhs(auth()->user()->mahasiswa->id);
        }

        return view('pages.dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
