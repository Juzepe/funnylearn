@extends('layouts.admin')

@section('content')
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li><a href="{{ url('/admin/words') }}">Words</a></li>
		</ol>
	</div><!--/.row-->
				
		
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Word</div>
				<div class="panel-body">
					
					{{ Form::model($word, ['route' => ['words.update', $word->id], 'method' => 'PUT']) }}

						<div class="form-group">
							<label>Book</label>
							
							<select class="form-control" id="book" onchange="getLessons(this)">
						        @foreach ($books as $book)
						        	<option value="{{$book->id}}" <?php if ($book->id == $word->lesson->book_id) : echo "selected"; endif ?>>
						        		{{$book->name}}
						        	</option>
						        @endforeach
						    </select>
						</div>

						<div class="form-group">
							<label>Lesson</label>
							
							<select class="form-control" id="lesson" name="lesson_id">
						        @foreach ($lessons as $lesson)
						        	<option value="{{$lesson->id}}" <?php if ($lesson->id == $word->lesson_id) : echo "selected"; endif ?>>
						        		{{$lesson->name}}
						        	</option>
						        @endforeach
						    </select>
							
							@if ($errors->has('lesson_id'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('lesson_id') }}</strong>
								</div>
							@endif
						</div>
						
						<div class="form-group">
							<label>Word</label>
							{{ Form::text('word', null, array('class' => 'form-control')) }}
							
							@if ($errors->has('word'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('word') }}</strong>
								</div>
							@endif
						</div>
						
						<div class="form-group">
							<label>Meaning</label>
							{{ Form::text('meaning', null, array('class' => 'form-control')) }}
							
							@if ($errors->has('meaning'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('meaning') }}</strong>
								</div>
							@endif
						</div>
						
						<button type="submit" class="btn btn-primary">Edit Word</button>
							
					{{ Form::close() }}
					
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
@stop

@include('admin.words.scripts')