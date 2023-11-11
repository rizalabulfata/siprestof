@extends('layouts.alter', ['title' => 'Detail Prestasi'])

@php
    function kolomShow($type): array
    {
        $default = [
            [
                'column' => 'mhs_nim',
                'label' => 'NIM',
            ],
            [
                'column' => 'mhs_name',
                'label' => 'Nama',
            ],
            [
                'column' => 'kod_code',
                'label' => 'Kode',
            ],
        ];

        $add = [];
        if ($type == 'aplikom') {
            $add = [
                [
                    'column' => 'bentuk_aplikom',
                    'label' => 'Bentuk Aplikom',
                ],
                [
                    'column' => 'year',
                    'label' => 'Tahun',
                ],
                [
                    'column' => 'url',
                    'label' => 'Tautan',
                ],
                [
                    'column' => 'desc',
                    'label' => 'Deskripsi',
                ],
            ];
        } elseif ($type == 'artikel') {
            $add = [
                [
                    'column' => 'name',
                    'label' => 'Judul',
                ],
                [
                    'column' => 'publisher',
                    'label' => 'Penerbit',
                ],
                [
                    'column' => 'issue_at',
                    'label' => 'Tanggal Terbit',
                ],
                [
                    'column' => 'url',
                    'label' => 'Link Artikel',
                ],
            ];
        } elseif ($type == 'buku') {
            $add = [
                [
                    'column' => 'name',
                    'label' => 'Judul Bukut',
                ],
                [
                    'column' => 'category',
                    'label' => 'Jenis Buku',
                ],
                [
                    'column' => 'publisher',
                    'label' => 'Penerbit',
                ],
                [
                    'column' => 'isbn',
                    'label' => 'Nomor ISBN',
                ],
                [
                    'column' => 'page_total',
                    'label' => 'Jumlah Halaman',
                ],
                [
                    'column' => 'year',
                    'label' => 'Tahun',
                ],
            ];
        } elseif ($type == 'desain_produk') {
            $add = [
                [
                    'column' => 'bentuk_desain',
                    'label' => 'Bentuk Desain',
                ],
                [
                    'column' => 'year',
                    'label' => 'Tahun',
                ],
            ];
        } elseif ($type == 'film') {
            $add = [
                [
                    'column' => 'name',
                    'label' => 'Judul',
                ],
                [
                    'column' => 'genre',
                    'label' => 'Genre',
                ],
                [
                    'column' => 'desc',
                    'label' => 'Deskripsi',
                ],
                [
                    'column' => 'date',
                    'label' => 'Tanggal',
                ],
                [
                    'column' => 'url',
                    'label' => 'Tautan',
                ],
            ];
        } elseif ($type == 'organisasi') {
            $add = [
                [
                    'column' => 'name',
                    'label' => 'Nama Organisasi',
                ],
                [
                    'column' => 'kod_second_name',
                    'label' => 'Jabatan',
                ],
                [
                    'column' => 'year_start',
                    'label' => 'Masa Jabatan',
                ],
                [
                    'column' => 'sk_number',
                    'label' => 'SK Jabatan',
                ],
            ];
        } elseif ($type == 'kompetisi') {
            $add = [
                [
                    'column' => 'name',
                    'label' => 'Nama Kompetisi',
                ],
                [
                    'column' => 'kod_kategori',
                    'label' => 'Kategori',
                ],
                [
                    'column' => 'desc',
                    'label' => 'Deskripsi',
                ],
                [
                    'column' => 'organizer',
                    'label' => 'Penyelenggara',
                ],
                [
                    'column' => 'type',
                    'label' => 'Tim/Individu',
                ],
                [
                    'column' => 'year',
                    'label' => 'Tahun',
                ],
            ];
        } elseif ($type == 'penghargaan') {
            $add = [
                [
                    'column' => 'name',
                    'label' => 'Penghargaan',
                ],
                [
                    'column' => 'desc',
                    'label' => 'Deskripsi',
                ],
                [
                    'column' => 'kod_kategori',
                    'label' => 'Tingkat',
                ],
                [
                    'column' => 'institution',
                    'label' => 'Institusi',
                ],
                [
                    'column' => 'date',
                    'label' => 'Tanggal',
                ],
            ];
        }

        return array_merge($default, $add);
    }
@endphp

@section('alter-content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail Prestasi</h6>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-bordered align-items-center mb-0 text-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode</th>
                                        <th colspan="3">Deskripsi</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        @php
                                            $details = $record->details;
                                        @endphp
                                        @foreach (kolomShow($record->type) as $detail)
                                            <tr>
                                                @if ($loop->index == 0)
                                                    <td rowspan="{{ count(kolomShow($record->type)) + 1 }}">
                                                        {{ $record->code }}</td>
                                                @endif
                                                <td>{{ $detail['label'] }}</td>
                                                <td>:</td>
                                                <td>{{ $details->{$detail['column']} }}</td>
                                                @if ($loop->index == 0)
                                                    <td rowspan="{{ count(kolomShow($record->type)) + 1 }}">
                                                        <a href="{{ route($resource . '.edit', ['aa', 'a']) }}"
                                                            class="btn btn-warning btn-xs"><i class="fas fa-pen"></i></a>
                                                        <a href="{{ route($resource . '.destroy', $details->id) }}"
                                                            class="btn btn-danger btn-xs"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Bukti</td>
                                            <td>:</td>
                                            <td>
                                                {{-- <a class="btn btn-sm btn-success"
                                                    href="{{ route('prestasi.detail', ['id' => $details->id, 'type' => $details->type]) }}"
                                                    onclick="getDocument(1)">Lihat</a> --}}
                                                <button class="btn btn-sm btn-success" href="#"
                                                    onclick="getDocument('{{ $details->id }}', '{{ $details->table_type }}')">Lihat</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showDocument" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tampilkan Sertifikat dan Dokumentasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <h4>Sertifikat</h4>
                        <div id="sertifikatBox"></div>
                    </div>
                    <div class="pt-3">
                        <h4>Dokumentasi</h4>
                        <div id="dokumentasiBox"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
@endsection

@section('script')
    <script>
        function getDocument(id, type) {
            const myModalAlternative = new bootstrap.Modal('#showDocument')
            var data = call(id, type);
            data.then((i) => {
                let imgExtension = ['jpg', 'jpeg', 'png']
                if (i.certificate) {
                    let box = document.getElementById('sertifikatBox')
                    box.innerHTML = ""
                    let certs = JSON.parse(i.certificate)
                    certs.forEach(e => {
                        let file = e.name.split('.')
                        let extension = file[file.length - 1].toLowerCase();

                        if (imgExtension.indexOf(extension) != -1) {
                            let img = new Image();
                            let url = '{{ asset('storage/fake') }}/' + e.name
                            img.src = url
                            img.classList.add('img-fluid');
                            img.classList.add('pb-3');
                            box.appendChild(img)
                        } else if (extension == 'pdf') {
                            let boxIframe = document.createElement('div')
                            let iframe = document.createElement('iframe')
                            let url = '{{ asset('storage/fake') }}/' + e.name
                            iframe.src = url
                            iframe.width = 800
                            boxIframe.classList.add('img-fluid');
                            boxIframe.classList.add('pb-3');
                            boxIframe.appendChild(iframe)
                            box.appendChild(boxIframe)
                        }
                    });

                }

                if (i.documentation) {
                    let box = document.getElementById('dokumentasiBox')
                    box.innerHTML = ""
                    let certs = JSON.parse(i.documentation)
                    certs.forEach(e => {
                        let file = e.name.split('.')
                        let extension = file[file.length - 1].toLowerCase();

                        if (imgExtension.indexOf(extension) != -1) {
                            let img = new Image();
                            let url = '{{ asset('storage/fake') }}/' + e.name
                            img.src = url
                            img.classList.add('img-fluid');
                            img.classList.add('pb-3');
                            box.appendChild(img)
                        } else if (extension == 'pdf') {
                            let boxIframe = document.createElement('div')
                            let iframe = document.createElement('iframe')
                            let url = '{{ asset('storage/fake') }}/' + e.name
                            iframe.src = url
                            iframe.width = 800
                            boxIframe.classList.add('img-fluid');
                            boxIframe.classList.add('pb-3');
                            boxIframe.appendChild(iframe)
                            box.appendChild(boxIframe)
                        }
                    });

                }
                myModalAlternative.show()
            })


        }

        async function call(id, type) {
            const response = await fetch("{{ route('api.prestasi.detail') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    'id': id,
                    'type': type
                })
            })

            return response.json();
        }
    </script>
@endsection
