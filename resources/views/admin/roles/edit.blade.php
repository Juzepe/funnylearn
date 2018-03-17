@extends('layouts.admin')
@section('content')
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="{{ url('/admin') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="{{ url('/admin/roles') }}">Roles</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Role</div>
					<div class="panel-body">
						
						{{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
							
								<div class="form-group">
									<label>Role Name</label>
									{{ Form::text('name', null, array('class' => 'form-control')) }}
									
									@if ($errors->has('name'))
										<br/>
										<div class="alert alert-danger">
											<strong>{{ $errors->first('name') }}</strong>
										</div>
									@endif
								</div>
								
								<div class="form-group">
									<label>Role Display Name</label>
									{{ Form::text('display_name', null, ['class' => 'form-control', 'placeholder' => 'Role Display Name']) }}
									
									@if ($errors->has('display_name'))
										<br/>
										<div class="alert alert-danger">
											<strong>{{ $errors->first('display_name') }}</strong>
										</div>
									@endif
								</div>
								
								<div class="form-group">
									<label>Role Description</label>
									{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) }}
									
									@if ($errors->has('description'))
										<br/>
										<div class="alert alert-danger">
											<strong>{{ $errors->first('description') }}</strong>
										</div>
									@endif
								</div>
								
								<div class="form-group">
									<label>Role Permissions</label>
									@foreach($permissions as $permission)
										<?php $checked = in_array($permission->id, $checkeds) ? true : false; ?>
										
										<div class="checkbox">
											<label>
												{{ Form::checkbox('permissions[]', $permission->id, $checked) }}
												{{ $permission->display_name }}
											</label>
										</div>
									@endforeach
									
									
								</div>
								
								<button type="submit" class="btn btn-primary">Edit Role</button>
								
						{{ Form::close() }}
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
@stop