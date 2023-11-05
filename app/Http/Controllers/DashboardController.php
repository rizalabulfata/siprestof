<?php

namespace App\Http\Controllers;

use App\Service\DashboardService;
use App\Service\PortofolioService;
use App\Service\PrestasiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DashboardService $service)
    {
        // ambil pending prestasi
        $prestasiService = new PrestasiService();
        $prestasi = $prestasiService->getPendingPrestasi();
        $data['prestasi'] = $prestasi;
        $data['prestasi_total'] = $prestasi->count();

        // ambil pending portofolio
        $portoService = new PortofolioService();
        $porto = $portoService->getPendingPortofolio();
        $data['porto'] = $porto;
        $data['porto_total'] = $porto->count();

        // summary dashboard
        $data['summary'] = $service->getSummary();

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
