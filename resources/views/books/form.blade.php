@php ($return = URL::previous() === route('books.index') || !isset ($book) ? 'books.index' : 'books.show')
{{ Form::hidden('return', $return) }}
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    {{ Form::label('title', 'Title', ['class'=>'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text('title', null, ['class'=>'form-control', 'required'=>true, 'autofocus'=>true]) }}

        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
    {{ Form::label('author', 'Author', ['class'=>'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text('author', null, ['class'=>'form-control', 'title'=>'Last, First', 'placeholder'=>'Last, First', 'required'=>true, 'pattern'=>'.+, .+']) }}

        @if ($errors->has('author'))
            <span class="help-block">
                <strong>{{ $errors->first('author') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('publication_date') ? ' has-error' : '' }}">
    {{ Form::label('publication_date', 'Publication Date', ['class'=>'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::date('publication_date', null, ['class'=>'form-control']) }}

        @if ($errors->has('isbn13'))
            <span class="help-block">
                <strong>{{ $errors->first('isbn13') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('isbn13') ? ' has-error' : '' }}">
    {{ Form::label('isbn13', 'ISBN-13', ['class'=>'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text('isbn13', null, ['class'=>'form-control', 'title'=>'13 digit ISBN.', 'size'=>'13', 'pattern'=>'^\d{13}$']) }}

        @if ($errors->has('isbn13'))
            <span class="help-block">
                <strong>{{ $errors->first('isbn13') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('cover') ? ' has-error' : '' }}">
    {{ Form::label('cover', 'Cover', ['class'=>'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::file('cover', ['class'=>'form-control', 'accept'=>'image/gif,image/jpeg,image/png']) }}

        @if ($errors->has('cover'))
            <span class="help-block">
                <strong>{{ $errors->first('cover') }}</strong>
            </span>
        @endif
    </div>
</div>

@if (!empty($hasImage))
<div class="form-group{{ $errors->has('delete_cover') ? ' has-error' : '' }}">
    <div class="col-md-4">
        <span class="pull-right">{{ Form::checkbox('delete_cover', null, false, ['id'=>'delete_cover']) }}</span>

        @if ($errors->has('delete'))
            <span class="help-block">
                <strong>{{ $errors->first('delete_cover') }}</strong>
            </span>
        @endif
    </div>
    
    {{ Form::label('delete_cover', 'Delete cover?', ['class'=>'col-md-6']) }}
</div>
@endif

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <a class="btn btn-small btn-info" href="{{ $return === 'books.index' ? route('books.index') : route('books.show', $book->id) }}">Cancel</a>
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    </div>
</div>
