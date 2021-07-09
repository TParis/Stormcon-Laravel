@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("county::index") }}">Counties</a></li>
        <li class="breadcrumb-item">{{ $county->name }}</li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
    <div class="container-fluid">
        <div class="card ml-auto mr-auto w-50">
            <div class="card-body">
                <h5 class="card-title">Edit County</h5>
                {{ Form::open(array('route' => array('county::update', $county->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
                <div class="form-group row">
                    {{ Form::label('name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('name', $county->name, array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4 p-2 text-center">
                        <a type="button" onClick="deleteCounty({{ $county->id }}, '{{ $county->name }}')" class="btn btn-danger w-100">Delete</a>
                    </div>
                    <div class="col-4 p-2 text-center">
                        <a href="{{ route("county::view", $county->id) }}" type="button" class="btn btn-primary w-100">Close</a>
                    </div>
                    <div class="col-4 p-2 text-center">
                        <input type="submit" class="btn btn-success w-100" value="Save Changes" />
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
