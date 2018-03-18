@extends('layouts.admin')

@section('content')
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li><a href="{{ url('/admin/lessons') }}">Lessons</a></li>
		</ol>
	</div><!--/.row-->
				
		
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Lesson</div>
				<div class="panel-body">
					
					{{ Form::model($lesson, ['route' => ['lessons.update', $lesson->id], 'method' => 'PUT']) }}
						
						<div class="form-group">
							<label>Book</label>
							{{ Form::select('book_id', $books, null, array('class' => 'form-control')) }}
							
							@if ($errors->has('book_id'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('book_id') }}</strong>
								</div>
							@endif
						</div>
						
						<div class="form-group">
							<label>Lesson</label>
							{{ Form::text('name', null, array('class' => 'form-control')) }}
							
							@if ($errors->has('name'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('name') }}</strong>
								</div>
							@endif
						</div>
						
						<button type="submit" class="btn btn-primary">Edit Lesson</button>
							
					{{ Form::close() }}
					
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
@stop