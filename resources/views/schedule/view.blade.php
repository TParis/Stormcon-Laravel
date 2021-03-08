@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("company::index") }}">Companies</a></li>
        <li class="breadcrumb-item">{{ $company->name }}</li>
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
    <h2 align="center">{{ $company->name }}</h2>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteCounty({{ $company->id }}, '{{ $company->name }}')" class="btn btn-danger w-100">Delete</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("company::index") }}" type="button" class="btn btn-primary w-100">Close</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("company::edit", $company->id) }}" class="btn btn-success w-100">Edit</a>
        </div>
    </div>
    <table class="table table-info rounded">
        <tbody>
        <tr>
            <th class="w-25 border-top-0">Name</th>
            <td class="w-25 border-top-0 border-right">{{ $company->name }}</td>
            <th class="w-25 border-top-0">Legal Name</th>
            <td class="w-25 border-top-0">{{ $company->legal_name }}</td>
        </tr>
        <tr>
            <th>Also Known As</th>
            <td class="border-right">{{ $company->also_known_as }}</td>
            <th>Type of Company</th>
            <td>{{ $company->type }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td class="border-right"><a href="tel:{{ $company->phone }}">{{ $company->phone }}</a></td>
            <th>Division</th>
            <td>{{ $company->division }}</td>
        </tr>
        <tr>
            <th>Fax Number</th>
            <td class="border-right">{{ $company->fax }}</td>
            <th>Number of Employees</th>
            <td>{{ $company->num_of_employees }}</td>
        </tr>
        <tr>
            <th>Website</th>
            <td class="border-right"><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></td>
            <th>Federal Tax ID</th>
            <td>{{ $company->federal_tax_id }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td class="border-right"><a href="https://www.google.com/maps/place/{{ $company->address }} {{ $company->city }} {{ $company->state }} {{ $company->zipcode }}" target="_blank">{{ $company->address }}</a></td>
            <th>State Tax ID</th>
            <td>{{ $company->state_tax_id }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td class="border-right">{{ $company->city }}</td>
            <th>SOS Number</th>
            <td>{{ $company->sos }}</td>
        </tr>
        <tr>
            <th>State</th>
            <td class="border-right">{{ $company->state }}</td>
            <th>CN Number</th>
            <td>{{ $company->cn }}</td>
        </tr>
        <tr>
            <th>Zipcode</th>
            <td class="border-right">{{ $company->zipcode }}</td>
            <th>SIC Code</th>
            <td>{{ $company->sic }}</td>
        </tr>
        </tbody>
    </table>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 align="center">Contacts</h3>
                <div class="container-fixed">
                    <table id="contacts" class="table table-sortable table-bordered table-striped display">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>State Status</th>
                            <th>Federal Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($company->contacts as $contact)
                            <tr id="{{ $species->id }}">
                                <td><a href="{{ route("species::view", $contact->id) }}">{{ $contact->name }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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

            $("#contacts").ready(function () {
                let mydatatable = $("#contacts").DataTable();
            });
        }
    </script>
@endsection
