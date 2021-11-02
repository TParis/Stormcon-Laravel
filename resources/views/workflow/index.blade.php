@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Workflow Templates</li>
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
        @if (Auth::user()->hasRole("Owner"))
        <a href="{{ route("workflow_template::create") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Create Template</a>
        @endif
		<table id="templates" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
                    <th>Name</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($templates as $template)
				<tr id="{{ $template->id }}">
                    <td><a href="{{ route("workflow_template::show", $template->id) }}">{{ $template->name }}</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
    @if (Auth::user()->hasRole("Owner"))
	<a href="{{ route("workflow_template::create") }}" class="btn btn-info add-btn"><i class="glyphicon glyphicon-plus"></i> Create Template</a>
    @endif
@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $("#templates").ready(function() {
                let mydatatable = $("#templates").DataTable();
            });
        }
    </script>
@endsection
