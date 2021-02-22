@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.books.index_title')</h4>
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
                        <a
                            href="{{ route('books.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th>@lang('crud.books.inputs.title')</th>
                            <th>@lang('crud.books.inputs.subtitle')</th>
                            <th>@lang('crud.books.inputs.isbn13')</th>
                            <th>@lang('crud.books.inputs.price')</th>
                            <th>@lang('crud.books.inputs.image')</th>
                            <th>@lang('crud.books.inputs.url')</th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td>{{ $book->title ?? '-' }}</td>
                            <td>{{ $book->subtitle ?? '-' }}</td>
                            <td>{{ $book->isbn13 ?? '-' }}</td>
                            <td>{{ $book->price ?? '-' }}</td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $book->image }}"
                                />
                            </td>
                            <td>{{ $book->url ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    <a href="{{ route('books.edit', $book) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light text-secondary"
                                        >
                                            <ion-icon name="create"></ion-icon>
                                        </button>
                                    </a>
                                    <a href="{{ route('books.show', $book) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light text-secondary"
                                        >
                                            <ion-icon name="eye"></ion-icon>
                                        </button>
                                    </a>
                                    <form
                                        action="{{ route('books.destroy', $book) }}"
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
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">{!! $books->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
