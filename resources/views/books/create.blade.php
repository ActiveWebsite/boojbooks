@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Book</div>
                <div class="panel-body">
                    {{ Form::open(['route' => 'books.store', 'files' => true, 'class' => 'form-horizontal']) }}
                    @include('books.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
