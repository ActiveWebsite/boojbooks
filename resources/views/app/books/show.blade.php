@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('books.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.books.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.books.inputs.title')</h5>
                    <span>{{ $book->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.books.inputs.subtitle')</h5>
                    <span>{{ $book->subtitle ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.books.inputs.isbn13')</h5>
                    <span>{{ $book->isbn13 ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.books.inputs.price')</h5>
                    <span>{{ $book->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.books.inputs.image')</h5>
                    <span>{{ $book->image ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.books.inputs.url')</h5>
                    <span>{{ $book->url ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('books.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                <a href="{{ route('books.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
