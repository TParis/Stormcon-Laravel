@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("species::index") }}">Endangered Species</a></li>
        <li class="breadcrumb-item">{{ $species->common_name }}</li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
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
    <h2 align="center">{{ $species->common_name }}</h2>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteSpecies({{ $species->id }}, '{{ $species->common_name }}')" class="btn btn-danger w-100">Delete</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("species::index") }}" type="button" class="btn btn-primary w-100">Close</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("species::edit", $species->id) }}" class="btn btn-success w-100">Edit</a>
        </div>
    </div>
    <table class="table table-info rounded">
        <tbody>
        <tr>
            <th class="w-25 border-top-0">Common Name</th>
            <td class="border-top-0">{{ $species->common_name }}</td>
        </tr>
        <tr>
            <th>Scientific Name</th>
            <td>{{ $species->scientific_name }}</td>
        </tr>
        <tr>
            <th>Group</th>
            <td>{{ $species->group }}</td>
        </tr>
        <tr>
            <th>State Status</th>
            <td>{{ $species->state_status }}</td>
        </tr>
        <tr>
            <th>Federal Status</th>
            <td>{{ $species->federal_status }}</td>
        </tr>
        <tr>
            <th>Species Info</th>
            <td>{{ $species->species_info }}</td>
        </tr>
        </tbody>
    </table>
    <h3 align="center">Counties</h3>
    <div class="container-fixed">
        <select class="form-control w-25" onChange="window.location='/endangeredspecies/addCounty/{{ $species->id }}/' + this.value">
            <option SELECTED>Add County</option>
            @foreach ($counties as $county)
                <option value="{{ $county->id }}">{{ $county->name }}</option>
            @endforeach
        </select>
        <table id="counties" class="table table-sortable table-bordered table-striped display">
            <thead>
            <tr>
                <th>County</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($species->counties as $county)
                <tr id="{{ $county->id }}">
                    <td><a href="{{ route("county::view", $county->id) }}">{{ $county->name }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <select class="form-control w-25" onChange="window.location='/endangeredspecies/addCounty/{{ $species->id }}/' + this.value">
            <option SELECTED>Add County</option>
            @foreach ($counties as $county)
                <option value="{{ $county->id }}">{{ $county->name }}</option>
            @endforeach
        </select>
    </div>
@endsection


@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#counties").ready(function () {
                let mydatatable = $("#counties").DataTable();
            });
        }
    </script>
@endsection
