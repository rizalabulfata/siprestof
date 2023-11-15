@extends('layouts.alter')

@section('alter-content')
    <div class="col-12">
        <div class="card mb-4">
            <x-alert :type="'a'" />
            <div class="card-header pb-0">
                <h6>{{ $title ?? '' }}</h6>
            </div>
            <div style="width: 600px; margin: auto;">
                <canvas id="chartBox"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        let labelsColor = {
            'aplikom': {
                'bg': 'rgba(255, 99, 132, 0.2)',
                'border': 'rgba(255, 99, 132, 1)',
            },
            'artikel': {
                'bg': 'rgba(114, 162, 235, 0.2)',
                'border': 'rgba(114, 162, 235, 1)',
            },
            'buku': {
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
        let label = "{{ implode(',', array_keys($records->toArray())) }}".split(',')
        let skor = "{{ implode(',', array_values($records->toArray())) }}".split(',')
        var bgColors = [];
        var borderColors = [];

        label.forEach(item => {
            bgColors.push(labelsColor[item.toLowerCase()].bg)
            borderColors.push(labelsColor[item.toLowerCase()].border)
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
