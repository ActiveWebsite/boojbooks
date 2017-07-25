@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reading List</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6"><span class="pull-right">Title</span></div>
                        <div class="col-md-6">{{ $book->title }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><span class="pull-right">Author</span></div>
                        <div class="col-md-6">{{ $book->author }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><span class="pull-right">ISBN-13</span></div>
                        <div class="col-md-6">{{ $book->isbn13 }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><span class="pull-right">Publication Date</span></div>
                        <div class="col-md-6">{{ date('F j, Y', strtotime($book->publication_date)) }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="pull-right"><a class="btn btn-small btn-info" href="{{ route('books.edit', $book->id) }}">Edit</a>
                                <a class="btn btn-small btn-info" href="{{ route('books.destroy', $book->id) }}">Delete</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
