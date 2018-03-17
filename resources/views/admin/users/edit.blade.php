@extends('layouts.admin')
@section('content')
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="{{ url('/admin') }}/admin"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="{{ url('/admin/users') }}">Users</a></li>
			</ol>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit User</div>
					<div class="panel-body">
						
						{{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
							
								<div class="form-group">
									<label>User Name</label><br/>
									{{ $user->name }}
								</div>
								
								<div class="form-group">
									<label>User Surname</label><br/>
									{{ $user->surname }}
								</div>
								
								<div class="form-group">
									<label>Email</label><br/>
									{{ $user->email }}
								</div>
								
								<div class="form-group">
									<label>User Roles</label>
									@foreach($roles as $role)
										@continue( !Auth::user()->can('appoint_admin') && $role->hasPermission('appoint_manager') )
										
										<?php $checked = in_array($role->id, $checkeds) ? true : false; ?>
										
										<div class="checkbox">
											<label>
												{{ Form::checkbox('roles[]', $role->id, $checked) }}
												{{ $role->display_name }}
											</label>
										</div>
									@endforeach
									
									
								</div>
								
								<button type="submit" class="btn btn-primary">Edit User</button>
								
						{{ Form::close() }}
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
@stop