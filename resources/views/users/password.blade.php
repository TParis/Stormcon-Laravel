@extends('layouts.app')

@section('content')
	<ol class="breadcrumb">
	  <li><a href="{{ url('/') }}">Home</a></li>
	  <li><a href="{{ route('users::index') }}">Users</a></li>
	  <li><a href="{{ route('users::view', $user->id) }}">{{ $user->name }}</a></li>
	  <li class="active">Change Password</li>
	</ol>
	@if(Session::has('success'))
	<div class="alert alert-success">{{ Session::get('success') }}</div>
	@endif
	@if(Session::has('error'))
	<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	@if (count($errors))
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="panel panel-default">
		{{ Form::open(array('route' => array('users::updatepass', $user->id), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
			<div class="panel-heading">
				<h2>Change Password</h2>
			</div>
			<div class="panel-body">
				<div class="container-fluid">
					<div class="row">
						<div class="form-group">
							{{ Form::label('name', 'Username', array('class' => 'col-sm-2 control-label')) }}
							<div class="col-sm-4">
								<span style="line-height: 36px;">{{ $user->name }}</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							{{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label required-field')) }}
							<div class="col-sm-4">
								{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							{{ Form::label('password_confirmation', 'Confirmation', array('class' => 'col-sm-2 control-label required-field')) }}
							<div class="col-sm-4">
								{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Password Confirmation')) }}
							</div>
						</div>
					</div>
				</div>
			<div class="panel-footer">
				<a href="{{route('users::view', $user->id)}}" class="btn btn-danger"><i class="fa fa-stop-circle"></i> Cancel</a>
				<button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-pencil"></i> Change Password</button>
			</div>
		{{ Form::close() }}
	</div>
@endsection
