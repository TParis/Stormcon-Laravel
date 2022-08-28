@extends('layout.app')

@section('content')
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
	  <li class="breadcrumb-item"><a href="{{ route('users::index') }}">Users</a></li>
	  <li class="breadcrumb-item">{{ $user->username }}</li>
	  <li  class="breadcrumb-item active">Change Password</li>
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
		{{ Form::open(array('route' => array('users::updatepass', $user->id), 'method' => 'post', 'class'	=> 'form-horizontal')) }}

        <div class="container">
            <div class="row">
                {{ Form::label('name', 'Username', array('class' => 'col-2 control-label')) }}
                <span class="col-8" style="line-height: 36px;"><strong>{{ $user->username }}</strong></span>
            </div>
            <div class="row">
                {{ Form::label('password', 'Password', array('class' => 'col-2 control-label required-field')) }}
                {{ Form::password('password', array('class' => 'col-8 form-control', 'placeholder' => 'New Password')) }}
            </div>
            <div class="row">
                {{ Form::label('password_confirmation', 'Confirmation', array('class' => 'col-2 control-label required-field')) }}
                {{ Form::password('password_confirmation', array('class' => 'col-8 form-control', 'placeholder' => 'Password Confirmation')) }}

            </div>
        </div>
    <br/>
        <a href="{{route('users::view', $user->id)}}" class="btn btn-danger"><i class="fa fa-stop-circle"></i> Cancel</a>
        <button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-pencil"></i> Change Password</button>
		{{ Form::close() }}
@endsection
