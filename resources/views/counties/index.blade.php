@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item active" aria-current="page">Counties</li>
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
        <a href="{{ route("county::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New County</a>
		<table id="counties" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($counties as $county)
				<tr id="{{ $county->id }}">
					<td><a href="{{ route("county::view", $county->id) }}">{{ $county->name }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<a href="{{ route("county::add") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Add New County</a>
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
