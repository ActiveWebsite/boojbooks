@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reading List</div>
                <div class="panel-body">
                    
                    @if (Session::has('message'))
                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                    
                    <div class="p-1 mb-1">
                        <a class="btn btn-small btn-info" href="{{ route('books.create') }}">Add Book</a>
                    </div>
                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Book</th>
                                <th>Date Added</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $key=>$value)
                            <tr>
                                <td>{{ $value->position }}</td>
                                <td><a href="{{ URL::to('books/'.$value->id) }}"><i>{{ $value->title }}</i> ({{ $value->author }})</a></td>
                                <td>{{ $value->created_at->format('F j, Y') }}</td>
                                
                                <td>
                                    <a class="btn btn-small btn-info" href="{{ route('books.edit',$value->id) }}">Edit</a>
                                    <a class="btn btn-small btn-info" href="{{ route('books.destroy',$value->id) }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
