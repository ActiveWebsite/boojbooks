@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('libraries.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.libraries.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.libraries.inputs.user_id')</h5>
                    <span>{{ optional($library->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.libraries.inputs.book_id')</h5>
                    <span>{{ optional($library->book)->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.libraries.inputs.order')</h5>
                    <span>{{ $library->order ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('libraries.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                <a href="{{ route('libraries.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>

            </div>
        </div>
    </div>
</div>
@endsection
