@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Projects</li>
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
        @if (Auth::user()->hasRole("Initiator") || Auth::user()->hasRole("Owner"))
        <a href="{{ route("project::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Start Project</a>
        @endif
		<table id="projects" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
                    <th>Name</th>
                    <th>Municipal S4</th>
                    <th>County</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($projects as $project)
				<tr id="{{ $project->id }}">
                    <td><a href="{{ route("project::view", $project->id) }}">{{ $project->name }}</a></td>
                    <td>{{ $project->local_official_ms4 }}</td>
                    <td>{{ $project->county }}</td>
                    <td>{{ $project->city }}</td>
                    <td>{{ $project->state }}</td>
                    <td>{{ $project->zipcode }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
    @if (Auth::user()->hasRole("Initiator") || Auth::user()->hasRole("Owner"))
	<a href="{{ route("project::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Start Project</a>
    @endif
@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $("#municipals").ready(function() {
                let mydatatable = $("#projects").DataTable();
            });
        }
    </script>
@endsection
