@extends('layouts.alter')

@section('alter-content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $title }}</p>
                                <h5 class="font-weight-bolder">
                                    {{ $records->total() ?? 0 }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="fas fa-user text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                                    <h5 class="font-weight-bolder">
                                        2,300
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="fas fa-list text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Prestasi</p>
                                <h5 class="font-weight-bolder">
                                    +3,462
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="fas fa-trophy text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Portofolio</p>
                                <h5 class="font-weight-bolder">
                                    $103,430
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
    </div>
    <div class="mt-5">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $title }}</p>
                        </div>
                        <div style="width: 600px; margin: auto;">
                            <canvas id="chartBox"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-list :records="$records" :title="$title ?? 'Daftar'" :columns="$tables" :resource="$resource" :buttons="@$buttons" :with-action-button="@$withActionButton" />
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        let labelsColor = {
            'Cukup': {
                'bg': 'rgba(255, 99, 132, 0.2)',
                'border': 'rgba(255, 99, 132, 1)',
            },
            'Memuaskan': {
                'bg': 'rgba(114, 162, 235, 0.2)',
                'border': 'rgba(114, 162, 235, 1)',
            },
            'Sangat Memuaskan': {
                'bg': 'rgba(255, 206, 86, 0.2)',
                'border': 'rgba(255, 206, 86, 1)',
            },
            'desain_produk': {
                'bg': 'rgba(75, 192, 192, 0.2)',
                'border': 'rgba(75, 192, 192, 1)',
            },
            'film': {
                'bg': 'rgba(153, 102, 255, 0.2)',
                'border': 'rgba(153, 102, 255, 1)',
            },
            'kompetisi': {
                'bg': 'rgba(255, 159, 64, 0.2)',
                'border': 'rgba(255, 159, 64, 1)',
            },
            'penghargaan': {
                'bg': 'rgba(244, 11, 91, 0.2)',
                'border': 'rgba(244, 11, 91, 1)',
            },
            'organisasi': {
                'bg': 'rgba(44, 160, 253, 0.2)',
                'border': 'rgba(44, 160, 253, 1)',
            },
        };
        let label = "{{ implode(',', array_keys($hk)) }}".split(',')
        let skor = "{{ implode(',', array_values($hk)) }}".split(',')
        var bgColors = [];
        var borderColors = [];

        label.forEach(item => {
            bgColors.push(labelsColor[item].bg)
            borderColors.push(labelsColor[item].border)
        });

        const ctx = document.getElementById('chartBox').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: label,
                datasets: [{
                    label: '# Total skor',
                    data: skor,
                    backgroundColor: bgColors,
                    borderColor: borderColors,
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
