@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("municipal::index") }}">Municipals</a></li>
        <li class="breadcrumb-item">{{ $municipal->name }}</li>
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
    <h2 align="center">{{ $municipal->name }}</h2>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteCounty({{ $municipal->id }}, '{{ $municipal->name }}')" class="btn btn-danger w-100">Delete</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("municipal::index") }}" type="button" class="btn btn-primary w-100">Close</a>
        </div>
        <div class="col-4 p-2 text-center">
            <a href="{{ route("municipal::edit", $municipal->id) }}" class="btn btn-success w-100">Edit</a>
        </div>
    </div>
    <table class="table table-info rounded">
        <tbody>
        <tr>
            <th class="w-25 border-top-0">Name</th>
            <td class="w-25 border-top-0 border-right">{{ $municipal->name }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td class="border-right"><a href="tel:{{ $municipal->phone }}">{{ $municipal->phone }}</a></td>
        </tr>
        <tr>
            <th>Address</th>
            <td class="border-right"><a href="https://www.google.com/maps/place/{{ $municipal->address }} {{ $municipal->city }} {{ $municipal->state }} {{ $municipal->zipcode }}" target="_blank">{{ $municipal->address }}</a></td>
        </tr>
        <tr>
            <th>City</th>
            <td class="border-right">{{ $municipal->city }}</td>
        </tr>
        <tr>
            <th>State</th>
            <td class="border-right">{{ $municipal->state }}</td>
        </tr>
        <tr>
            <th>Zipcode</th>
            <td class="border-right">{{ $municipal->zipcode }}</td>
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
                            <th>Title</th>
                            <th>Division</th>
                            <th>Phone</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($municipal->contacts as $contact)
                            <tr id="{{ $contact->id }}">
                                <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                <td>{{ $contact->title }}</td>
                                <td>{{ $contact->division }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->email }}</td>
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
