	<div class="panel panel-default">
		@if (Auth::user()->can('permissions.edit'))
		{{ Form::open(array('route' => array('users::perms', $user->id), 'method' => 'post', 'id' => 'permissions', 'class'	=> 'form-horizontal')) }}
		@endif
		<div class="panel-heading">
			<h3>Permissions</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-4"><h3>Company</h3></div>
				<div class="col-md-4"><h3>Timesheets</h3></div>
				<div class="col-md-4"><h3>Datasheets</h3></div>
			</div>
			@foreach ($companies as $company)
				<div class="row row-striped">
				<div class="col-md-4"><strong>{{ $company->name }}</strong></div>
				<div class="col-md-1">{{ Form::checkbox('invoice.' . $company->id . '.view', 'Read',		$user->hasPermissionTo('invoice.' . $company->id . '.view'), 		array('data-class' => 'invoice', 	'data-act' => 'view',		'data-id' => $company->id)) }} View</div>
				<div class="col-md-1">{{ Form::checkbox('invoice.' . $company->id . '.editAll', 'Edit',		$user->hasPermissionTo('invoice.' . $company->id . '.editAll'), 	array('data-class' => 'invoice', 	'data-act' => 'edit', 		'data-id' => $company->id)) }} Edit</div>
				<div class="col-md-2">{{ Form::checkbox('invoice.' . $company->id . '.editOwn', 'Edit Own', $user->hasPermissionTo('invoice.' . $company->id . '.editOwn'),  	array('data-class' => 'invoice', 	'data-act' => 'editown',	'data-id' => $company->id)) }} Edit Own</div>
				<div class="col-md-1">{{ Form::checkbox('datasheet.' . $company->id . '.view', 'Read',		$user->hasPermissionTo('datasheet.' . $company->id . '.view'), 		array('data-class' => 'datasheet', 	'data-act' => 'view', 		'data-id' => $company->id)) }} View</div>
				<div class="col-md-3">{{ Form::checkbox('datasheet.' . $company->id . '.edit', 'Edit',		$user->hasPermissionTo('datasheet.' . $company->id . '.edit'), 		array('data-class' => 'datasheet', 	'data-act' => 'edit', 		'data-id' => $company->id)) }} Edit</div>

				</div>
			@endforeach
		</div>
		@if (Auth::user()->can('permissions.edit'))
		<div class="panel-footer">
			<div class="container-fluid">
				<div class="row">
					<button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-pencil"></i> Update Permissions</button>
				</div>
			</div>
		</div>
		{{ Form::close() }}
		@endif
	</div>
