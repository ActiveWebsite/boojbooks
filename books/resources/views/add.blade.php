@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Add Book</div>
				<div class="panel-body">
					<form action="/home/save" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group row">
							<label for="title" class="col-sm-2 col-form-label">Title</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title" />
							</div>
						</div>
						<div class="form-group row">
							<label for="author" class="col-sm-2 col-form-label">Author</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="author" />
							</div>
						</div>
						<div class="form-group row">
							<label for="publication_date" class="col-sm-2 col-form-label">Publication
								Date</label>
							<div class="col-sm-10">
								<input type="text" class="form-control datepicker"
									name="publication_date" data-date-format="yyyy-mm-dd"
									placeholder="yyyy-mm-dd" />
							</div>
						</div>

						<button type="submit" class="btn btn-primary">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
