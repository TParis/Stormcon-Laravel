@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item active" aria-current="page">Companies</li>
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
        <a href="{{ route("company::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New Company</a>
		<table id="companies" class="table table-sortable table-bordered table-striped display">
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
			@foreach ($companies as $company)
				<tr id="{{ $company->id }}">
                    <td><a href="{{ route("company::view", $company->id) }}">{{ $company->name }}</a></td>
                    <td>{{ $company->phone }}</td>
                    <td>{{ $company->city }}</td>
                    <td>{{ $company->state }}</td>
                    <td>{{ $company->zipcode }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<a href="{{ route("company::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New Company</a>
@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $("#companies").ready(function() {
                let mydatatable = $("#companies").DataTable();
            });
        }
    </script>
@endsection
