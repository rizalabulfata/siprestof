@props([
    'title' => 'Data',
    'records' => [],
    'columns' => [],
    'resource' => null,
    'allowedVisibility' => [Route::currentRouteName()],
])

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <x-alert :type="true" />
            <div class="card-header pb-0">
                <h6>{{ $title }}</h6>
                <a href="{{ route($resource . '.create') }}" class="btn btn-primary btn-xs"><i class="fas fa-plus"> </i>
                    Tambah</a>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
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
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        @foreach ($columns as $column)
                                            @isset($column['visibility'])
                                                @foreach ($column['visibility'] as $v)
                                                    @if (in_array($v, $allowedVisibility))
                                                        <td class="align-middle text-center text-sm">
                                                            <p class="text-sm font-weight-bold mb-0">
                                                                {{ $record->{$column['column']} ?? $record[$column['column']] }}
                                                            </p>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        @endforeach
                                        <td class="align-middle text-center">
                                            <form
                                                action="{{ route($resource . '.destroy', $record->id ?? $record['id']) }}"
                                                method="POST">
                                                <a href="{{ route($resource . '.show', $record->id ?? $record['id']) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route($resource . '.edit', $record->id ?? $record['id']) }}"
                                                    class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="far fa-trash-alt"></i></a>
                                            </form>
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
                        @else
                            {{ $records->links() }}
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
