@extends('layouts.admin')

@section('content')
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li>Lessons</li>
		</ol>
	</div><!--/.row-->
		
	@if (Session::has('message'))
		<div class="alert alert-info col-lg-12">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('message') }}
		</div>
	@endif
		
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Lessons</h1>
		</div>
	</div><!--/.row--><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Lesson</div>

				<div class="panel-body">
					
					<form role="form" action="{{ url('admin/lessons') }}" method="POST">
						{{ csrf_field() }}
					
						<div class="form-group">
							<label>Book</label>
							<select class="form-control" name="book_id">
						        <option value=""> - </option>

						        @foreach ($books as $book)
						        	<option value="{{$book->id}}">{{$book->name}}</option>
						        @endforeach
						    </select>
							
							@if ($errors->has('book_id'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('book_id') }}</strong>
								</div>
							@endif
						</div>
						
						<div class="form-group">
							<label>Lesson</label>
							<input type="text" name="name" class="form-control" placeholder="Lesson" value="{{ old('name') }}">
							
							@if ($errors->has('name'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('name') }}</strong>
								</div>
							@endif
						</div>
						
						<button type="submit" class="btn btn-primary">Add Lesson</button>
					</form>
					
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table id="books-table" class="table table-striped table-bordered">
					    <thead>
					    <tr>
					        <th data-field="id" data-sortable="true">ID</th>
					        <th data-field="name"  data-sortable="true">Book</th>
					        <th data-field="name" data-sortable="true">Lesson</th>
					        <th data-field="active" data-sortable="true">Status</th>
					        <th data-field="created_at" data-sortable="true">Created At</th>
					        <th data-field="updated_at"  data-sortable="true">Updated At</th>
					        <th data-field="action"  data-sortable="false">Action</th>
					    </tr>
					    </thead>
					</table>
				</div>
			</div>
		</div>
	</div><!--/.row-->	
@stop

@push('scripts')
<script>
$(function() {
    $('#books-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! url('admin/alllessons') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'book.name', name: 'book.name' },
            { data: 'name', name: 'name' },
            { data: 'active', name: 'active' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
		language: {
            "url": "{{$langLink}}"
        }
    });
});
</script>
@endpush