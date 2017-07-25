<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    {!! Form::label('title', 'Title', ['class'=>'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('title', null, ['class'=>'form-control', 'required'=>true, 'autofocus'=>true]) !!}

        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
    {!! Form::label('author', 'Author', ['class'=>'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('author', null, ['class'=>'form-control', 'title'=>'Last, First', 'placeholder'=>'Last, First', 'required'=>true, 'pattern'=>'.+, .+']) !!}

        @if ($errors->has('author'))
            <span class="help-block">
                <strong>{{ $errors->first('author') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('publication_date') ? ' has-error' : '' }}">
    {!! Form::label('publication_date', 'Publication Date', ['class'=>'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::date('publication_date', null, ['class'=>'form-control']) !!}

        @if ($errors->has('isbn13'))
            <span class="help-block">
                <strong>{{ $errors->first('isbn13') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('isbn13') ? ' has-error' : '' }}">
    {!! Form::label('isbn13', 'ISBN-13', ['class'=>'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('isbn13', null, ['class'=>'form-control', 'title'=>'13 digit ISBN.', 'size'=>'13', 'pattern'=>'^\d{13}$']) !!}

        @if ($errors->has('isbn13'))
            <span class="help-block">
                <strong>{{ $errors->first('isbn13') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <a class="btn btn-small btn-info" href="{{ URL::previous() === route('books.index') ? route('books.index') : route('books.show', $book->id) }}">Cancel</a>
        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
