@extends('layouts.admin')
@section('content')
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li>Roles</li>
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
				<h1 class="page-header">Roles</h1>
			</div>
		</div><!--/.row--><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Add New Role</div>
					<div class="panel-body">
						
						<form role="form" action="{{ url('admin/roles') }}" method="POST">
							{{ csrf_field() }}
							
								<div class="form-group">
									<label>Role Name</label>
									<input type="text" name="name" class="form-control" placeholder="Role Name" value="{{ old('name') }}">
									
									@if ($errors->has('name'))
										<br/>
										<div class="alert alert-danger">
											<strong>{{ $errors->first('name') }}</strong>
										</div>
									@endif
								</div>
								
								<div class="form-group">
									<label>Role Display Name</label>
									<input type="text" name="display_name" class="form-control" placeholder="Role Display Name" value="{{ old('display_name') }}">
									
									@if ($errors->has('display_name'))
										<br/>
										<div class="alert alert-danger">
											<strong>{{ $errors->first('display_name') }}</strong>
										</div>
									@endif
								</div>
								
								<div class="form-group">
									<label>Role Description</label>
									<textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
									
									@if ($errors->has('description'))
										<br/>
										<div class="alert alert-danger">
											<strong>{{ $errors->first('description') }}</strong>
										</div>
									@endif
								</div>
								
								<button type="submit" class="btn btn-primary">Add Role</button>
								
						</form>
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
	
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<table id="roles-table" class="table table-striped table-bordered">
						    <thead>
						    <tr>
						        <th data-field="id" data-sortable="true">ID</th>
						        <th data-field="name"  data-sortable="true">Role Name</th>
						        <th data-field="display_name" data-sortable="true">Display Name</th>
						        <th data-field="description"  data-sortable="true">Description</th>
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
        ajax: '{!! url('admin/allroles') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'display_name', name: 'display_name' },
            { data: 'description', name: 'description' },
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