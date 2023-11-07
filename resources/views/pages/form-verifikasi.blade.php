@php
    $allowedVisibility = [Route::currentRouteName()];
@endphp
@extends('layouts.alter')

@section('alter-content')
    <div class="col-12">
        <div class="card mb-4">
            <x-alert :type="'a'" />
            <div class="card-header pb-0">
                <a href="{{ route($resource . '.index') }}" type="button" class="btn btn-default"><i
                        class="fas fa-arrow-left"></i><span class="ps-2">Kembali</span></a>
                <h6>{{ $title ?? '' }}</h6>
            </div>
            <form class="p-3" method="POST" action="{{ route($resource . '.store') }}">
                @csrf
                <input type="hidden" id="typecu">
                @isset($forms)
                    @foreach ($forms as $form)
                        @isset($form['visibility'])
                            @foreach ($form['visibility'] as $v)
                                @if (in_array($v, $allowedVisibility))
                                    @if ($form['type'] == 'text')
                                        <x-input-text :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column']) ?? $records->{$form['column']}"
                                            :readonly="@$form['readonly']" />
                                    @elseif($form['type'] == 'select')
                                        <x-input-select :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column'])"
                                            :options="@$form['options']" />
                                    @elseif($form['type'] == 'email')
                                        <x-input-email :label="$form['name']" :name="$form['column']" :required="@$form['required']"
                                            :value="old($form['column'])" />
                                    @elseif($form['type'] == 'number')
                                        <x-input-number :label="$form['name']" :name="$form['column']"
                                            :required="@$form['required']":value="old($form['column'])" />
                                    @elseif($form['type'] == 'textarea')
                                        <x-input-textarea :label="$form['name']" :name="$form['column']" :required="@$form['required']"
                                            :value="old($form['column'])" />
                                    @elseif($form['type'] == 'date')
                                        <x-input-date :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column'])" />
                                    @endif
                                @endif
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
                <div class="form-group">
                    <a class="btn  btn-info" onclick="getDocumentVerif('{{ $records->id }}', '{{ $type }}')">
                        <i class="fas fa-folder-open"></i>
                        @if ($type == 'desain_produk')
                            <span class="ps-2">Lihat Mockup Desain</span>
                        @elseif($type == 'organisasi')
                            <span class="ps-2">Lihat Sertifikat Organisasi</span>
                        @else
                            <span class="ps-2">Lihat Bukti Sertifikat dan Dokumentasi</span>
                        @endif
                    </a>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-sm">Terima</button>
                    <a type="button" href="{{ isset($resource) ? route($resource . '.index') : '#' }}"
                        class="btn btn-danger btn-sm">Tolak</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showDocumentVerifikasi" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tampilkan Sertifikat dan Dokumentasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    @if ($type == 'desain_produk')
                        <div class="">
                            <h4>Mockup</h4>
                            <div id="mockupBox"></div>
                        </div>
                    @else
                        <div class="">
                            <h4>Sertifikat</h4>
                            <div id="sertifikatBox"></div>
                        </div>
                        <div class="pt-3">
                            <h4>Dokumentasi</h4>
                            <div id="dokumentasiBox"></div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function getDocumentVerif(id, type) {
            const myModalAlternative = new bootstrap.Modal('#showDocumentVerifikasi')
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

                if (i.mockup) {
                    let box = document.getElementById('mockupBox')
                    box.innerHTML = ""
                    let certs = JSON.parse(i.mockup)
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
