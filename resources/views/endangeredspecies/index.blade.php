@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item active" aria-current="page">Endangered Species</li>
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
        <a href="{{ route("species::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New Endangered Species</a>
		<table id="counties" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
                    <th>Common Name</th>
                    <th>Scientific Name</th>
                    <th>Group</th>
                    <th>State Status</th>
                    <th>Federal Status</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($species_list as $species)
				<tr id="{{ $species->id }}">
                    <td><a href="{{ route("species::view", $species->id) }}">{{ $species->common_name }}</td>
                    <td>{{ $species->scientific_name }}</td>
                    <td>{{ $species->group }}</td>
                    <td>{{ $species->state_status }}</td>
                    <td>{{ $species->federal_status }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<a href="{{ route("species::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New Endangered Species</a>
@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $("#counties").ready(function() {
                let mydatatable = $("#counties").DataTable();
            });
        }
    </script>
@endsection
