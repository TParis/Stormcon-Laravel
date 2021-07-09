@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (count($errors))
        <p>Errors: {{ count($errors) }}</p>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2 align="center">{{ $user->username }}</h2>
    {{ Form::open(array('route' => array('profile::update', $user->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
    <div class="form-group row">
        <div class="col-6 p-2 text-center">
            <a href="{{ route("password.request") }}" class="btn btn-danger w-100">Reset Password</a>
        </div>
        <div class="col-6 p-2 text-center">
            <button type="submit" class="btn btn-primary w-100">Save Settings</button>
        </div>
    </div>
    <table class="table table-info rounded">
        <tbody>
        <tr>
            <th class="w-25">User ID:</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Username:</th>
            <td>{{ $user->username }}</td>
        </tr>
        <tr>
            <th>Full Name:</th>
            <td>{{ $user->fullName }}</td>
        </tr>
        <tr>
            <th>Roles:</th>
            <td>{{ implode(", ", $user->getRoleNames()->toArray()) }}</td>
        </tr>
        <tr>
            <th>Phone Number:</th>
            <td>{{ Form::text('phone', $user->phone, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>{{ Form::text('email', $user->email, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <th>Receive Notifications:</th>
            <td>{{ Form::select('notifications', ['0' => 'No', '1' => 'Yes'], $user->notifications, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <th>Schedule:</th>
            <td>{{ Form::select('notifications_schedule', ['instant' => 'Instant', 'daily' => 'Daily', 'weekly' => 'Weekly'], $user->notifications_schedule, ['class' => 'form-control']) }}</td>
        </tr>
        </tbody>
    </table>
    {{ Form::close() }}
@endsection
