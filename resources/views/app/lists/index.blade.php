@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.library.index_title')</h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <ion-icon name="search"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\Library::class)
                        <a
                            href="{{ route('lists.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th>@lang('crud.library.inputs.user_id')</th>
                            <th>@lang('crud.library.inputs.book_id')</th>
                            <th>@lang('crud.library.inputs.order')</th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lists as $library)
                        <tr>
                            <td>{{ $library->user_id ?? '-' }}</td>
                            <td>{{ $library->book_id ?? '-' }}</td>
                            <td>{{ $library->order ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $library)
                                    <a
                                        href="{{ route('lists.edit', $library) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light text-secondary"
                                        >
                                            <ion-icon name="create"></ion-icon>
                                        </button>
                                    </a>
                                    @endcan @can('view', $library)
                                    <a
                                        href="{{ route('lists.show', $library) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light text-secondary"
                                        >
                                            <ion-icon name="eye"></ion-icon>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $library)
                                    <form
                                        action="{{ route('lists.destroy', $library) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">{!! $lists->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
