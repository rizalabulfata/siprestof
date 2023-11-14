@props([
    'title' => 'Data',
    'records' => [],
    'columns' => [],
    'resource' => null,
    'buttons' => [],
    'allowedVisibility' => [Route::currentRouteName()],
    'withActionButton' => true,
])

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <x-alert :type="true" />
            <div class="card-header pb-0">
                <h6>{{ $title }}</h6>
                @if (!empty($buttons))
                    @foreach ($buttons as $button)
                        @isset($button['role'])
                            @can($button['role'])
                                <a href="{{ $button['url'] }}" class="{{ $button['class'] }}">
                                    @if (isset($button['icon']))
                                        <i class="{{ $button['icon'] }}">
                                        </i>
                                    @endif
                                    {{ @$button['text'] }}
                                </a>
                            @endcan
                        @endisset
                    @endforeach
                @endif
                {{-- @can('isMahasiswa')
                    @if (!empty($buttons))
                        @foreach ($buttons as $button)
                            <a href="{{ $button['url'] }}" class="{{ $button['class'] }}">
                                @if (isset($button['icon']))
                                    <i class="{{ $button['icon'] }}">
                                    </i>
                                @endif
                                {{ @$button['text'] }}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ route($resource . '.create') }}" class="btn btn-primary btn-xs"><i
                                class="fas fa-plus"></i>Tambah</a>
                    @endif
                @endcan --}}
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        #</th>
                                    @foreach ($columns as $column)
                                        @isset($column['visibility'])
                                            @foreach ($column['visibility'] as $v)
                                                @if (in_array($v, $allowedVisibility))
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        {{ $column['name'] }}
                                                    </th>
                                                @endif
                                            @endforeach
                                        @endisset
                                    @endforeach
                                    @if ($withActionButton)
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $ind => $record)
                                    <tr>
                                        <td class="align-middle text-center text-sm">{{ $ind + 1 }}</td>
                                        @foreach ($columns as $column)
                                            @isset($column['visibility'])
                                                @foreach ($column['visibility'] as $v)
                                                    @if (in_array($v, $allowedVisibility))
                                                        <td class="align-middle text-center text-sm">
                                                            <p class="text-sm font-weight-bold mb-0">
                                                                @if ($column['column'] == 'type')
                                                                    @php
                                                                        $value = $record->{$column['column']} ?? $record[$column['column']];
                                                                        $value = ucfirst(str_replace('_', ' ', $value));
                                                                    @endphp
                                                                    {{ $value }}
                                                                @else
                                                                    {{ $record->{$column['column']} ?? $record[$column['column']] }}
                                                                @endif
                                                            </p>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        @endforeach
                                        @if ($withActionButton)
                                            <td class="align-middle text-center">
                                                @php
                                                    $id = $record->id ?? ($record['id'] ?? ($record->event_id ?? $record['event_id']));
                                                    $portoApprove = ['aplikom', 'artikel', 'buku', 'desain_produk', 'film', 'kompetisi', 'penghargaan', 'organisasi'];
                                                    $allowsEditDelete = ['mahasiswa.index'];
                                                @endphp
                                                @can('isAdmin')
                                                    <form action="{{ route($resource . '.destroy', $id) }}" method="POST">
                                                        <a href="{{ route($resource . '.show', $id) }}"
                                                            class="btn btn-info btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Lihat"><i
                                                                class="fas fa-eye"></i></a>
                                                        @if (in_array(Route::currentRouteName(), $allowsEditDelete))
                                                            <a href="{{ route($resource . '.edit', $id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Edit"><i
                                                                    class="fas fa-pen"></i></a>
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                data-toggle="tooltip" data-placement="top" title="Hapus"><i
                                                                    class="far fa-trash-alt"></i></a>
                                                        @endif
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route($resource . '.destroy', $id . '__' . $record['type']) }}"
                                                        method="POST">
                                                        <a href="{{ route($resource . '.show', $id . '__' . $record['type']) }}"
                                                            class="btn btn-info btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Lihat"><i
                                                                class="fas fa-eye"></i></a>
                                                        @if (!in_array($record->type ?? $record['type'], $portoApprove))
                                                            <a href="{{ route($resource . '.edit', $id . '__' . $record['type']) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Edit"><i
                                                                    class="fas fa-pen"></i></a>
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                data-toggle="tooltip" data-placement="top" title="Hapus"><i
                                                                    class="far fa-trash-alt"></i></a>
                                                        @endif
                                                    </form>
                                                @endcan
                                            </td>
                                        @endif
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
                        @else
                            {{ $records->links() }}
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
