@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("county::index") }}">Counties</a></li>
        <li class="breadcrumb-item">{{ $county->name }}</li>
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
    <h2 align="center">{{ $county->name }}</h2>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteCounty({{ $county->id }}, '{{ $county->name }}')" class="btn btn-danger w-100">Delete</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("county::index") }}" type="button" class="btn btn-primary w-100">Close</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("county::edit", $county->id) }}" class="btn btn-success w-100">Edit</a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 border-right">
                <h3 align="center">Endangered Species</h3>
                <h6 align="center">Species that are protected within this county</h6>
                <div class="container-fixed">
                    <select class="form-control w-50" onChange="window.location='/endangeredspecies/addCounty/' + this.value + '/{{ $county->id }}'">
                        <option SELECTED>Add Species</option>
                        @foreach ($endangered_species_list as $species_key => $species_group)
                            <optgroup label="{{ $species_key }}">
                                @foreach ($species_group as $new_species)
                                    <option value="{{ $new_species->id }}">{{ $new_species->common_name }}</option>
                        @endforeach
                        @endforeach
                    </select>
                    <table id="endangered_species" class="table table-sortable table-bordered table-striped display">
                        <thead>
                        <tr>
                            <th>Common Name</th>
                            <th>State Status</th>
                            <th>Federal Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($county->endangered_species as $species)
                            <tr id="{{ $species->id }}">
                                <td><a href="{{ route("species::view", $species->id) }}">{{ $species->common_name }}</a></td>
                                <td>{{ $species->state_status }}</td>
                                <td>{{ $species->federal_status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <select class="form-control w-50" onChange="window.location='/endangeredspecies/addCounty/' + this.value + '/{{ $county->id }}'">
                        <option SELECTED>Add Species</option>
                        @foreach ($endangered_species_list as $species_key => $species_group)
                            <optgroup label="{{ $species_key }}">
                                @foreach ($species_group as $new_species)
                                    <option value="{{ $new_species->id }}">{{ $new_species->common_name }}</option>
                        @endforeach
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-6">
                <h3 align="center">Companies</h3>
                <h6 align="center">Companies that operate within this county</h6>
                <div class="container-fixed">
                    <select class="form-control w-50" onChange="window.location='/companies/addCounty/' + this.value + '/{{ $county->id }}'">
                        <option SELECTED>Add Company</option>
                        @foreach ($companies_list as $city => $companies)
                            <optgroup label="{{ $city }}">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                        @endforeach
                    </select>
                    <table id="companies" class="table table-sortable table-bordered table-striped display">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Also Known As</th>
                            <th>Phone Number</th>
                            <th>City</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($county->companies as $company)
                            <tr id="{{ $company->id }}">
                                <td><a href="{{ route("company::view", $company->id) }}">{{ $company->name }}</a></td>
                                <td>{{ $company->also_known_as }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>{{ $company->city }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <select class="form-control w-50" onChange="window.location='/companies/addCounty/' + this.value + '/{{ $county->id }}'">
                        <option SELECTED>Add Company</option>
                        @foreach ($companies_list as $city => $companies)
                            <optgroup label="{{ $city }}">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
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

            $("#companies").ready(function () {
                let mydatatable = $("#companies").DataTable();
            });
            $("#endangered_species").ready(function () {
                let mydatatable = $("#endangered_species").DataTable();
            });
        }
    </script>
@endsection
