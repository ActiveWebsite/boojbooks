@extends('layouts.app')

@section('title', $book->title)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (Session::has('message'))
                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-3">
                            @if (!empty($imagePath))
                                <img src="{{ asset($imagePath) }}" alt="{{ $book->title }}" title="{{ $book->title }}" class="img-responsive img-thumbnail">
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4"><span class="pull-right">Title</span></div>
                                <div class="col-md-8">{{ $book->title }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><span class="pull-right">Author</span></div>
                                <div class="col-md-8">{{ $book->author }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><span class="pull-right">ISBN-13</span></div>
                                <div class="col-md-8">{{ $book->isbn13 }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><span class="pull-right">Publication Date</span></div>
                                <div class="col-md-8">{{ !empty($book->publication_date) ? date('F j, Y', strtotime($book->publication_date)) : '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <a class="btn btn-small btn-info" href="{{ route('books.index') }}">Back to List</a>
                        </div>
                        <div class="col-md-8">
                            {{ Form::open(['method' => 'DELETE', 'route' => ['books.destroy', $book->id]]) }}
                                <span class="pull-right"><a class="btn btn-small btn-info" href="{{ route('books.edit', $book->id) }}">Edit</a>
                                {{ Form::hidden('id', $book->id) }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?")']) }}</span>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
