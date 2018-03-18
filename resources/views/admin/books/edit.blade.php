@extends('layouts.admin')

@section('content')
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li><a href="{{ url('/admin/books') }}">Books</a></li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Book</div>
				<div class="panel-body">
					
					{{ Form::model($book, array('route' => array('books.update', $book->id), 'method' => 'PUT')) }}
						
						<div class="form-group">
							<label>Book Name</label>
							{{ Form::text('name', null, array('class' => 'form-control')) }}
							
							@if ($errors->has('name'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('name') }}</strong>
								</div>
							@endif
						</div>
						
						<div class="form-group">
							<label>Book Name</label>
							{{ Form::text('note', null, array('class' => 'form-control')) }}
							
							@if ($errors->has('note'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('note') }}</strong>
								</div>
							@endif
						</div>
						
						<button type="submit" class="btn btn-primary">Edit Book</button>
							
					{{ Form::close() }}
					
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
@stop