@extends('layouts.app')

@section('title', 'Reading List')

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
                                <th class="text-center"><a href="{{ route(Route::currentRouteName(), ['desc'=>($orderby === 'position' && $desc === false) ? true : null]) }}">#</a></th>
                                <th><a href="{{ route(Route::currentRouteName(), ['orderby'=>'title', 'desc'=>($orderby === 'title' && $desc === false) ? true : null]) }}">Title</a></th>
                                <th><a href="{{ route(Route::currentRouteName(), ['orderby'=>'author', 'desc'=>($orderby === 'author' && $desc === false) ? true : null]) }}">Author</a></th>
                                <th>Date Added</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $key=>$value)
                            <tr>
                                <td class="text-center">
                                    @if ($key > 0)
                                    {{ Form::open(['method' => 'PUT', 'route' => ['books.moveup', $value->id]]) }}
                                        {{ Form::hidden('id', $value->id) }}
                                        {{ Form::submit('Up', ['class' => 'btn btn-xs btn-info', 'style' => 'width: 3.5em;']) }}
                                    {{ Form::close() }}
                                    @endif
                                    @if ($key < count($books)-1)
                                    {{ Form::open(['method' => 'PUT', 'route' => ['books.movedown', $value->id]]) }}
                                        {{ Form::hidden('id', $value->id) }}
                                        {{ Form::submit('Down', ['class' => 'btn btn-xs btn-info', 'style' => 'width: 3.5em;']) }}
                                    {{ Form::close() }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $value->position + 1 }}</td>
                                <td><a href="{{ URL::to('books/'.$value->id) }}"><i>{{ $value->title }}</i></a></td>
                                <td>{{ $value->author }}</td>
                                <td>{{ $value->created_at->format('F j, Y') }}</td>
                                
                                <td>
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['books.destroy', $value->id]]) }}
                                        <a class="btn btn-small btn-info" href="{{ route('books.edit', $value->id) }}">Edit</a>
                                        {{ Form::hidden('id', $value->id) }}
                                        {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?")']) }}
                                    {{ Form::close() }}
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
