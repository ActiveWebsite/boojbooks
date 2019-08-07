@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Saved Books</div>
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-4">Title</div>
						<div class="col-md-3">
							<a href="/home?sort=author&desc={{$desc}}">Author</a>
						</div>
						<div class="col-md-3">Publication Date</div>
						<div class="col-md-3"></div>
					</div>
				</div>
				<div class="panel-body">
					@isset($books) @foreach ($books as $book)
					<div class="row">
						<div class="col-md-4">{{ $book->title }}</div>
						<div class="col-md-3">{{ $book->author }}</div>
						<div class="col-md-3">{{ $book->publication_date }}</div>
						<div class="col-md-2">
							<a href="/home/delete/{{ $book->id }}"><span
								class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							<a href="/home/move/up/{{ $book->id }}"><span
								class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
							<a href="/home/move/down/{{ $book->id }}"><span
								class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
						</div>
					</div>
					@endforeach @endisset
				</div>

				<div class="panel-heading">
					<a href="/home/add" class="btn btn-primary active" role="button"
						aria-pressed="true">Add New Book</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
