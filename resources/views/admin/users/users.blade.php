@extends('layouts.admin')
@section('content')
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li>Users</li>
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
			<h1 class="page-header">Users</h1>
		</div>
	</div><!--/.row--><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table id="roles-table" class="table table-bordered">
						<thead>
							<tr>
								<th data-field="id" data-sortable="true">ID</th>
								<th data-field="name"  data-sortable="true">User Name</th>
								<th data-field="email"  data-sortable="true">Email</th>
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
    $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! url('admin/allusers') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
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