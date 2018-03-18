@extends('layouts.admin')

@push('styles')
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }

        tfoot {
            display: table-header-group;
        }
    </style>
@endPush

@section('content')
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li>Words</li>
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
			<h1 class="page-header">Words</h1>
		</div>
	</div><!--/.row--><!--/.row-->
				
		
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Words</div>
				<div class="panel-body">
					
					<form role="form" action="{{ url('admin/words') }}" method="POST">
						{{ csrf_field() }}
					
						<div class="form-group">
							<label>Book</label>
							<select class="form-control" id="book" onchange="getLessons(this)">
						        <option value=""> - </option>

						        @foreach ($books as $book)
						        	<option value="{{$book->id}}">{{$book->name}}</option>
						        @endforeach
						    </select>
						</div>

						<div class="form-group">
							<label>Lesson</label>
							
							<select class="form-control" id="lesson" name="lesson_id">
						        <option value=""> - </option>
						    </select>
							
							@if ($errors->has('lesson_id'))
								<br/>
								<div class="alert alert-danger">
									<strong>{{ $errors->first('lesson_id') }}</strong>
								</div>
							@endif
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6" id="words_container">
									<label>Words</label>
									<input type="text" name="words[1]" class="form-control" placeholder="Word">
								</div>

								<div class="col-sm-6" id="meanings_container">
									<label>Meanings</label>
									<input type="text" name="meanings[1]" class="form-control" placeholder="Meaning">
								</div>
							</div>
						</div>
						
						<div type="submit" class="btn btn-info" onclick="addWord()">Add Word</div>
						<button type="submit" class="btn btn-primary">Add Words</button>
					</form>
					
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<table id="cars-table" class="table table-bordered">
						    <thead>
						    <tr>
						        <th data-field="id" data-sortable="true">ID</th>
					        	<th data-field="lesson.book.name"  data-sortable="true">Book</th>
					        	<th data-field="lesson.name"  data-sortable="true">Lesson</th>
						        <th data-field="word"  data-sortable="true">Word</th>
						        <th data-field="meaning"  data-sortable="true">Meaning</th>
						        <th data-field="created_at" data-sortable="true">Created At</th>
						        <th data-field="updated_at"  data-sortable="true">Updated At</th>
						        <th data-field="action"  data-sortable="false">Action</th>
						    </tr>
						    </thead>
			                <tfoot>
			                <tr>
						        <th data-field="id" data-sortable="true">ID</th>
					        	<th data-field="lesson.book.name"  data-sortable="true">Book</th>
					        	<th data-field="lesson.name"  data-sortable="true">Lesson</th>
						        <th data-field="word"  data-sortable="true">Word</th>
						        <th data-field="meaning"  data-sortable="true">Meaning</th>
						        <th data-field="created_at" data-sortable="true">Created At</th>
						        <th data-field="updated_at"  data-sortable="true">Updated At</th>
						        <th data-field="action"  data-sortable="false">Action</th>
			                </tr>
			                </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	
@stop

@push('scripts')
<script>
	$(function() {
	    $('#cars-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{!! url('admin/allwords') !!}',
	        columns: [
	            { data: 'id', name: 'id' },
	            { data: 'lesson.book.name', name: 'lesson.book.name' },
	            { data: 'lesson.name', name: 'lesson.name' },
	            { data: 'word', name: 'word' },
	            { data: 'meaning', name: 'meaning' },
	            { data: 'created_at', name: 'created_at' },
	            { data: 'updated_at', name: 'updated_at' },
	            { data: 'action', name: 'action', orderable: false, searchable: false },
	        ],
			language: {
	            "url": "{{$langLink}}"
	        },
	        initComplete: function () {
	            this.api().columns().every(function () {
	                var column = this;
	                var columnClass = column.footer().attributes.class;

	                var attributes = {};

	                if (this.length) {
	                    $.each(this.footer().attributes, function (index, attr) {
	                        attributes[attr.name] = attr.value;
	                    });
	                }

	                if (attributes.class != 'non_searchable') {
	                    var input = document.createElement("input");
	                    $(input).appendTo($(column.footer()).empty())
	                        .on('change', function () {
	                            column.search($(this).val(), false, false, true).draw();
	                        });
	                }
	            });
	        },
	    });
	});

    window.wordIndex = 1;

	function addWord() { 
        window.wordIndex++;

        var words_container = document.getElementById('words_container');
        var meanings_container = document.getElementById('meanings_container');

		words_container.innerHTML += '<br/><input type="text" name="words['+window.wordIndex+']" class="form-control" placeholder="Word">';
		meanings_container.innerHTML += '<br/><input type="text" name="meanings['+window.wordIndex+']" class="form-control" placeholder="Meaning">';
    }
</script>
@endpush

@include('admin.words.scripts')