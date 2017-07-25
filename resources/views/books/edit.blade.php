@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Book</div>
                <div class="panel-body">
                    {!! Form::model($book, ['method' => 'PUT', 'route' => ['books.update', $book->id], 'class' => 'form-horizontal']) !!}
                    @include('books.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
