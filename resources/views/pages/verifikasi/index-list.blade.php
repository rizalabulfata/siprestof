@extends('layouts.alter')

@section('alter-content')
    <div class="row mt-4 mx-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $title }}</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $records->total() }}
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
        </div>


        <div class="row mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <x-alert :type="true" />
                    <div class="card-header pb-0">
                        <h6>{{ $title }}</h6>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                #</th>
                                            @foreach ($columns as $column)
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    {{ $column['name'] }}
                                                </th>
                                            @endforeach
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $ind => $record)
                                            <tr>
                                                <td class="align-middle text-center text-sm">{{ $ind + 1 }}</td>
                                                @foreach ($columns as $column)
                                                    <td class="align-middle text-sm">
                                                        <p class="text-sm font-weight-bold mb-0">
                                                            @if ($column['column'] == 'type')
                                                                {{ ucfirst(str_replace('_', ' ', $record->{$column['column']} ?? $record[$column['column']])) }}
                                                            @else
                                                                {{ $record->{$column['column']} ?? $record[$column['column']] }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                @endforeach
                                                <td class="align-middle text-center">

                                                    <form
                                                        action="{{ route($resource . '.destroy', $record->event_id . '__' . $record->type) }}"
                                                        method="POST"></form>
                                                    <a href="{{ route('verifikasi.show', $record->type . '__' . $record->event_id) }}"
                                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    @can('isMahasiswa')
                                                        {{-- <a href="{{ route($resource . '.edit', $record->event_id . '__' . $record->type) }}"
                                                            class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Edit"><i class="fas fa-pen"></i></a>
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" data-placement="top" title="Hapus"><i
                                                                class="far fa-trash-alt"></i></a> --}}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                @if (request()->search_box)
                                    {{ $records->appends(['search_box' => request()->search_box])->links() }}
                                @elseif(request()->type)
                                    {{ $records->appends(['type' => request()->type])->links() }}
                                @else
                                    {{ $records->links() }}
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
