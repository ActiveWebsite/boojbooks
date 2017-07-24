@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($id) ? 'Edit' : 'New' }} Book</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ isset($id) ? route('books.update', $id) : route('books.store') }}">
                        {{ csrf_field() }}
                        @if($new !== true)
                            <input id="id" type="hidden" class="form-control" name="id" value="{{ $id }}">
                        @endif
                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="title" value="{{ old('title', $title) }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
                            <label for="author" class="col-md-4 control-label">Author</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="author" value="{{ old('author', $author) }}" required pattern="{{ $rules['author']['pattern'] }}" title="Last, First" placeholder="Last, First">

                                @if ($errors->has('author'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('author') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('isbn13') ? ' has-error' : '' }}">
                            <label for="publication_date" class="col-md-4 control-label">Publication Date</label>

                            <div class="col-md-6">
                                <input id="name" type="date" class="form-control" name="publication_date" value="{{ old('publication_date', $publication_date) }}">

                                @if ($errors->has('publication_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('publication_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('isbn13') ? ' has-error' : '' }}">
                            <label for="isbn13" class="col-md-4 control-label">ISBN-13</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="isbn13" value="{{ old('isbn13', $isbn13) }}" pattern="{{ $rules['isbn13']['pattern'] }}" title="13 digit ISBN.">
                                {{ Form::input }}

                                @if ($errors->has('isbn13'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('isbn13') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
