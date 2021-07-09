@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item active" aria-current="page">Municipals</li>
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
	<div class="container-fixed">
        <a href="{{ route("municipal::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New Municipal</a>
		<table id="municipals" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($municipals as $municipal)
				<tr id="{{ $municipal->id }}">
                    <td><a href="{{ route("municipal::view", $municipal->id) }}">{{ $municipal->name }}</a></td>
                    <td>{{ $municipal->phone }}</td>
                    <td>{{ $municipal->city }}</td>
                    <td>{{ $municipal->state }}</td>
                    <td>{{ $municipal->zipcode }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<a href="{{ route("municipal::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New Municipal</a>
@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $("#municipals").ready(function() {
                let mydatatable = $("#municipals").DataTable();
            });
        }
    </script>
@endsection
